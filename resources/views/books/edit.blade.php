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
                    <form class="p-6 space-y-6">
                        <!-- Book Cover Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Book Cover</label>
                            <div class="flex items-start space-x-6">
                                <!-- Preview Area -->
                                <div class="flex-shrink-0">
                                    <div id="imagePreview"
                                        class="w-32 h-44 rounded-lg bg-gray-100 border-2 border-gray-200 flex items-center justify-center overflow-hidden">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-300">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Upload Area -->
                                <div class="flex-1">
                                    <div id="uploadZone" class="upload-zone rounded-lg p-6 text-center cursor-pointer"
                                        onclick="document.getElementById('coverImage').click()">
                                        <input type="file" id="coverImage" name="coverImage" accept="image/*" class="hidden"
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
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Recommended: 300x400px ratio</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Book Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="Enter book title" />
                            </div>

                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">ISBN <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="isbn" name="isbn" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="978-0-7475-3269-9" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author <span
                                        class="text-red-500">*</span></label>
                                <select id="author" name="author" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    <option value="">Select an author</option>
                                    <option value="1">J.K. Rowling</option>
                                    <option value="2">Stephen King</option>
                                    <option value="3">George Orwell</option>
                                </select>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category <span
                                        class="text-red-500">*</span></label>
                                <select id="category" name="category" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    <option value="">Select a category</option>
                                    <option value="1">Fiction</option>
                                    <option value="2">Science</option>
                                    <option value="3">History</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                                placeholder="Enter book description"></textarea>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="status" name="status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="available">Available</option>
                                <option value="borrowed">Borrowed</option>
                                <option value="reserved">Reserved</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="./book-list.html"
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md">
                                Create Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection