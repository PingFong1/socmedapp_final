<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" ng-app="socialApp" ng-controller="PostController">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Post Creation Form -->
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h3 class="font-semibold text-xl mb-4">Create a Post</h3>
                <form ng-submit="createPost()" class="space-y-4">
                    <!-- CSRF token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <textarea ng-model="newPost.content" class="form-control w-full p-3 border border-gray-300 rounded-lg shadow-sm" placeholder="What's on your mind?" required></textarea>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md shadow hover:bg-blue-600 transition">Post</button>
                </form>
            </div>

            <!-- Display Recent Posts -->
            <div class="space-y-6">
                <h3 class="font-semibold text-2xl mb-6">Recent Posts</h3>
                <div ng-repeat="post in posts" class="post-card bg-white shadow-lg rounded-xl p-6 mb-6">
                    <!-- Display post content -->
                    <div ng-if="!post.isEditing">
                        <p class="text-lg text-gray-800 mb-3" ng-bind="post.content"></p>
                    </div>

                    <!-- Editable post content -->
                    <div ng-if="post.isEditing">
                        <textarea ng-model="post.editingContent" class="form-control w-full p-3 border border-gray-300 rounded-lg shadow-sm" required></textarea>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <button ng-if="post.user_id === userId" ng-click="editPost(post)" class="btn btn-warning text-sm">
                            <span ng-if="!post.isEditing">Edit</span>
                            <span ng-if="post.isEditing">Save</span>
                        </button>

                        <p class="text-sm text-gray-600">Posted by: <span ng-bind="post.user.name"></span></p>
                        <small class="text-gray-500" ng-bind="post.created_at"></small>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <!-- Like Button -->
                        <div>
                            <button ng-click="likePost(post.id)" class="btn btn-sm py-1 px-4 text-sm text-white rounded-lg" ng-class="{'bg-red-500': post.liked_by_user, 'bg-gray-300': !post.liked_by_user}">
                                <i class="bi bi-heart" ng-class="{'bi-heart-fill': post.liked_by_user, 'bi-heart': !post.liked_by_user}"></i> Like
                            </button>
                            <button ng-click="unlikePost(post.id)" class="btn btn-sm py-1 px-4 text-sm text-white rounded-lg ml-2" ng-class="{'bg-gray-500': post.liked_by_user, 'bg-gray-300': !post.liked_by_user}">
                                <i class="bi bi-heart-fill" ng-class="{'bi-heart-fill': post.liked_by_user, 'bi-heart': !post.liked_by_user}"></i> Unlike
                            </button>
                        </div>
                        <p class="text-sm text-gray-600">Likes: <span ng-bind="post.likes_count"></span></p>
                    </div>

                    <!-- Comment Section -->
                    <div class="mt-6">
                        <textarea ng-model="newComment[post.id]" class="form-control w-full p-3 border border-gray-300 rounded-lg shadow-sm mb-4" placeholder="Add a comment" required></textarea>
                        <button ng-click="addComment(post.id)" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">Comment</button>

                        <!-- Display Comments -->
                        <div class="mt-4">
                            <div class="comment-card bg-gray-100 p-4 mb-4 rounded-md" ng-repeat="comment in post.comments">
                                <div class="flex items-center mb-2">
                                    <strong ng-bind="comment.user.name" class="mr-2"></strong>
                                    <small class="text-gray-500" ng-bind="comment.created_at | date:'short'"></small>
                                </div>

                                <div ng-if="!comment.isEditing">
                                    <p class="comment-content text-gray-700" ng-bind="comment.content"></p>
                                </div>
                                <div ng-if="comment.isEditing">
                                    <textarea ng-model="comment.editingContent" class="form-control w-full p-3 border border-gray-300 rounded-lg" placeholder="Edit your comment"></textarea>
                                </div>

                                <div class="flex space-x-4 mt-2">
                                    <button ng-if="comment.user_id === userId" ng-click="editComment(post.id, comment)" class="btn btn-sm btn-warning text-xs">
                                        <span ng-if="!comment.isEditing">Edit</span>
                                        <span ng-if="comment.isEditing">Save</span>
                                    </button>
                                    <button ng-if="comment.user_id === userId" ng-click="deleteComment(post.id, comment.id)" class="btn btn-sm btn-danger text-xs">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
