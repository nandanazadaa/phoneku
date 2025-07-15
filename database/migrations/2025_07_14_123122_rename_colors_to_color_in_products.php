<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class RenameColorsToColorInProducts extends Migration
   {
       /**
        * Run the migrations.
        */
       public function up()
       {
           Schema::table('products', function (Blueprint $table) {
               $table->renameColumn('colors', 'color');
           });
       }

       /**
        * Reverse the migrations.
        */
       public function down()
       {
           Schema::table('products', function (Blueprint $table) {
               $table->renameColumn('color', 'colors');
           });
       }
   }
