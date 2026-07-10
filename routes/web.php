<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchedulingController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ping', function () {
    return 'pong';
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('faculties', FacultyController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('rooms', RoomController::class);
    Route::get('schedules', [SchedulingController::class, 'index'])->name('schedules.index');
    Route::get('schedules/create', [SchedulingController::class, 'create'])->name('schedules.create');
    Route::post('schedules/generate', [SchedulingController::class, 'generate'])->name('schedules.generate');
    Route::get('schedules/{schedule}', [SchedulingController::class, 'show'])->name('schedules.show');
    Route::delete('schedules/{schedule}', [SchedulingController::class, 'destroy'])->name('schedules.destroy');

    Route::get('schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::patch('schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.status');

    Route::get('reports/faculty-workload', [ReportController::class, 'facultyWorkload'])->name('reports.faculty-workload');
    Route::get('reports/faculty-schedule/{faculty}', [ReportController::class, 'facultySchedule'])->name('reports.faculty-schedule');
    Route::get('reports/class-program', [ReportController::class, 'classProgram'])->name('reports.class-program');
    Route::get('reports/subject-assignments', [ReportController::class, 'subjectAssignments'])->name('reports.subject-assignments');
    Route::get('reports/room-utilization', [ReportController::class, 'roomUtilization'])->name('reports.room-utilization');

    Route::get('archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::post('archives', [ArchiveController::class, 'store'])->name('archives.store');
    Route::get('archives/{archive}', [ArchiveController::class, 'show'])->name('archives.show');

    Route::get('outputs/matrix', [OutputController::class, 'matrix'])->name('outputs.matrix');
    Route::get('outputs/workload', [OutputController::class, 'workload'])->name('outputs.workload');
    Route::get('outputs/workload/{faculty}/pdf', [OutputController::class, 'workloadPdf'])->name('outputs.workload-pdf');
    Route::get('outputs/class-program', [OutputController::class, 'classProgram'])->name('outputs.class-program');
    Route::get('outputs/class-program/{section}/pdf', [OutputController::class, 'classProgramPdf'])->name('outputs.class-program-pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
