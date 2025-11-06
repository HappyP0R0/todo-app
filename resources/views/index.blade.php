<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex justify-center items-start p-8 font-poppins">

<div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">TODO LIST</h1>

    <div class="flex items-center gap-2 mb-4">
        <form method="GET" action="{{ route('tasks.index') }}" class="flex w-full gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Search note..."
                class="flex-1 border border-gray-300 rounded-xl py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            <select name="filter"
                    onchange="this.form.submit()"
                    class="bg-blue-500 text-white rounded-xl px-4 py-2 font-medium focus:outline-none cursor-pointer">
                <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>ALL</option>
                <option value="active" {{ ($filter ?? '') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                <option value="completed" {{ ($filter ?? '') === 'completed' ? 'selected' : '' }}>COMPLETED</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-xl px-4 py-2 font-medium">
                Search
            </button>
        </form>
    </div>

    <div class="flex flex-col gap-2">
        @forelse ($tasks as $task)
            <div class="flex justify-between items-center bg-blue-50 hover:bg-blue-100 transition rounded-xl px-4 py-2">
                <div class="flex items-center gap-3">
                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox"
                               onChange="this.form.submit()"
                               class="w-5 h-5 text-blue-600 rounded focus:ring-blue-400"
                            {{ $task->is_completed ? 'checked' : '' }}>
                    </form>
                    <div class="flex flex-col gap-3">
                    <a href="{{ route('tasks.edit', $task->id)  }}" class="text-gray-800 {{ $task->is_completed ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </a>
                    <span class="text-gray-400">{{  Str::excerpt($task->description, '', ['radius' => 8]) }}</span>
                    </div>
                </div>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition cursor-pointer">✕</button>
                </form>
            </div>
        @empty
            <p class="text-center text-gray-400 mt-4">No tasks yet.</p>
        @endforelse
    </div>
</div>

<button
    onclick="window.location='{{ route('tasks.create') }}'"
    class="fixed bottom-8 right-8 bg-blue-500 hover:bg-blue-600 text-white text-3xl rounded-full w-14 h-14 shadow-lg flex items-center justify-center">
    +
</button>

</body>
</html>

