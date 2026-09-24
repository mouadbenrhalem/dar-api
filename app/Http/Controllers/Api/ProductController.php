<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Models\AdminActivity; use App\Models\Product; use Illuminate\Http\Request;
class ProductController extends Controller {
 public function index(Request $request){ return Product::when($request->boolean('available_only'),fn($q)=>$q->where('is_available',true))->latest()->get(); }
 public function store(Request $request){$data=$request->validate(['name'=>'required|string|max:255','category'=>'nullable|string|max:255','price'=>'required|numeric|min:0','image_path'=>'nullable|string|max:255','description'=>'nullable|string','is_available'=>'boolean','stock'=>'nullable|integer|min:0']);$product=Product::create($data);$this->activity('product_added',$product,"Product {$product->name} added");return response()->json($product,201);}
 public function update(Request $request, Product $product){$data=$request->validate(['name'=>'sometimes|required|string|max:255','category'=>'nullable|string|max:255','price'=>'sometimes|required|numeric|min:0','image_path'=>'nullable|string|max:255','description'=>'nullable|string','is_available'=>'boolean','stock'=>'nullable|integer|min:0']);$changedPrice=array_key_exists('price',$data)&&$data['price']!=$product->price;$product->update($data);$this->activity($changedPrice?'price_changed':'product_updated',$product,"Product {$product->name} updated");return $product->fresh();}
 public function destroy(Product $product){$name=$product->name;$this->activity('product_deleted',$product,"Product {$name} deleted");$product->delete();return response()->noContent();}
 private function activity($action,$product,$description){AdminActivity::create(['action'=>$action,'subject_type'=>'product','subject_id'=>$product->id,'description'=>$description]);}
}
