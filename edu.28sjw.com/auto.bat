@echo off
php artisan make:migration create_paper_table
php artisan make:migration create_question_table
php artisan make:migration create_sheet_table
pause;