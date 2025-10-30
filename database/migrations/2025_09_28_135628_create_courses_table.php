<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('instructor_id');

            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->boolean('is_free')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->string('thumbnail')->nullable();
            $table->string('promo_video_url')->nullable();

            $table->integer('duration_minutes')->nullable();
            $table->integer('total_lectures')->nullable();
            $table->tinyInteger('level')->default(1); // 1=Beginner, 2=Intermediate, 3=Advanced
            $table->string('language')->default('English');

            $table->tinyInteger('status')->default(1); // active or inactive
            $table->integer('total_enrollments')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('category')->nullable();
            $table->string('tags')->nullable();

            $table->timestamps();

            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
