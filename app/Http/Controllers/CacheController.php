<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
  public function clearCache()
  {
      // Clear the application cache
      Artisan::call('cache:clear');

      // Clear the route cache
      Artisan::call('route:clear');

      // Optimize the autoloader and clear compiled views
      Artisan::call('optimize:clear');
      
      return "Cache cleared successfully.";
  }

}
