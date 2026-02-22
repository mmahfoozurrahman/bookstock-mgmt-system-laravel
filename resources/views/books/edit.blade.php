@extends('layouts.authenticated')

@section('content')

    <!-- Content -->
    <div class="flex-1 p-6 lg:p-8">
        <div class="mb-2">
            @include('flash.session')
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
            <div class="overflow-x-auto">
                <div class="p-6">
                    <form class="p-6 space-y-6" method="POST" action="{{ route('books.update', $book->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Book Cover Upload -->
                        {{-- ===== Cover Image ===== --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                            <div class="flex items-start space-x-4">

                                {{-- Show existing image OR placeholder --}}
                                <div id="imagePreview"
                                    class="w-24 h-32 rounded-lg bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden shrink-0">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                            class="w-full h-full object-cover" />
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909" />
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <div id="uploadZone" class="upload-zone rounded-lg p-6 text-center cursor-pointer"
                                        onclick="document.getElementById('cover_image').click()">
                                        <input type="file" id="cover_image" name="cover_image"
                                            accept="image/jpeg,image/png,image/jpg" class="hidden"
                                            onchange="previewImage(event)" />
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-10 h-10 text-gray-400 mx-auto mb-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <p class="text-sm text-gray-600 mb-1">
                                            <span class="font-medium text-indigo-600">Click to upload</span> or drag and
                                            drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                    </div>
                                    {{-- Validation Error for cover_image --}}
                                    @error('cover_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ===== Title & ISBN ===== --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Book Title <span class="text-red-500">*</span>
                                </label>
                                {{--
                                old('title', $book->title) means:
                                - First try: use old() value (if form re-submitted after validation error)
                                - Fallback: use $book->title (the current saved value)
                                --}}
                                <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('title') border-red-400 @enderror" />
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                                    ISBN <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('isbn') border-red-400 @enderror" />
                                @error('isbn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- ===== Author & Category Dropdowns ===== --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="author_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Author <span class="text-red-500">*</span>
                                </label>
                                <select id="author_id" name="author_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('author_id') border-red-400 @enderror">
                                    <option value="">Select an author</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" @selected(old('author_id', $book->author_id) == $author->id)>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('author_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" name="category_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('category_id') border-red-400 @enderror">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- ===== Published Date ===== --}}
                        <div class="mb-6">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Published
                                Date</label>
                            <input type="date" id="published_at" name="published_at"
                                value="{{ old('published_at', $book->published_at) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" />
                        </div>

                        {{-- ===== Description ===== --}}
                        <div class="mb-8">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none">{{ old('description', $book->description) }}</textarea>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="status" name="status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="available" @selected(old('status', $book->status) == 'available')>Available
                                </option>
                                <option value="borrowed" @selected(old('status', $book->status) == 'borrowed')>Borrowed
                                </option>
                                <option value="reserved" @selected(old('status', $book->status) == 'reserved')>Reserved
                                </option>
                            </select>

                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('books.index') }}"
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md">
                                Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .upload-zone {
            border: 2px dashed #d1d5db;
            transition: all 0.2s ease;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.getElementById('userMenuButton');
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Image preview functionality
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="w-full h-full object-cover" />';
                }
                reader.readAsDataURL(file);
            }
        }

        // Drag and drop functionality
        const uploadZone = document.getElementById('uploadZone');

        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('cover_image').files = e.dataTransfer.files;
                const event = { target: { files: [file] } };

                previewImage(event);
            }
        });
    </script>
@endsection