<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel TODO App</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-xl">
    <h1 class="text-2xl font-bold mb-4 text-center">Edit your TODO</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="mb-4 flex flex-col gap-2">
        @csrf
        <input value="{{ $task->title }}" type="text" name="title" placeholder="Task title" class="flex-1 border border-gray-300 rounded-xl py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        <textarea name="description" placeholder="Description" class="flex-1 border border-gray-300 rounded-xl py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ $task->description  }}</textarea>
        <button class="bg-blue-500 text-white rounded-xl px-4 py-2 font-medium focus:outline-none cursor-pointer">Update Task</button>
    </form>
</div>
</body>
</html>
