<?php
namespace Database\Seeders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
 public function run() {
  $adminEmail = env('ADMIN_EMAIL');
  $adminPassword = env('ADMIN_PASSWORD');
  if (!$adminEmail || !$adminPassword) {
   throw new \RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD in backend/.env before seeding the administrator account.');
  }
  User::updateOrCreate(['email'=>$adminEmail],['name'=>'Dar Goût Admin','password'=>Hash::make($adminPassword),'is_admin'=>true]);
  foreach ([
   ['Baghrir maison','Baghrir',1,'/baghrir.webp','Baghrir moelleux préparé maison.'], ['Khobz traditionnel','Pains Marocains',1,'/KK22.24.jpeg','Pain marocain artisanal frais.'], ['Harcha traditionnelle','Harcha',2,'/MM.jpeg','Harcha de semoule dorée.'], ['Msemen feuilleté','Msemen & Crêpes',2.5,'/msemen-picturepartners-bigstock.jpg.webp','Msemen maison feuilleté.'], ['Harcha mini au miel','Harcha',2.5,'/original-02CEC337-0D7A-4915-9349-BF8A43EFE91A.webp','Petites harchas maison.'], ['Msemen rond maison','Msemen & Crêpes',2.5,'/ll.jpeg','Msemen rond doré et généreux.']
  ] as [$name,$category,$price,$image_path,$description]) Product::updateOrCreate(['name'=>$name],compact('category','price','image_path','description')+['is_available'=>true]);
 }
}
