<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">

    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <a class="text-white text-2xl mx-2 font-semibold" href="{{route('dashboard')}}">{{config('app.name')}}</a>
        </div>
    </div>

    <nav class="mt-10">
        <?php
            $items = [
                [
                    'name' => __('base::app.dashboard'),
                    'icon' => Base::icon('home', ['class' => 'h-6 w-6']),
                    'url' => 'dashboard',
                ],
                [
                    'name' => __('base::models.user.plural'),
                    'icon' => Base::icon('users', ['class' => 'h-6 w-6']),
                    'url' => 'users.index',
                    'crud' => 'users',
                ],
                [
                    'name' => __('base::models.blog.plural'),
                    'icon' => Base::icon('book-open', ['class' => 'h-6 w-6']),
                    'items' => [
                        [
                            'name' => __('base::models.blog.plural'),
                            'icon' => Base::icon('book-open', ['class' => 'h-6 w-6']),
                            'url' => 'blogs.index',
                            'crud' => 'blogs',
                        ],
                        [
                            'name' => __('base::models.blog-post.plural'),
                            'icon' => Base::icon('book-open', ['class' => 'h-6 w-6']),
                            'url' => 'blog-posts.index',
                            'crud' => 'blog-posts',
                        ],
                        [
                            'name' => __('base::models.tag.plural'),
                            'icon' => Base::icon('tag', ['class' => 'h-6 w-6']),
                            'url' => 'tags.index',
                            'crud' => 'tags',
                        ],
                    ],
                ],
                [
                    'name' => __('base::models.image.plural'),
                    'icon' => Base::icon('photograph', ['class' => 'h-6 w-6']),
                    'items' => [
                        [
                            'name' => __('base::models.image-group.plural'),
                            'icon' => Base::icon('photograph', ['class' => 'h-6 w-6']),
                            'url' => 'image-groups.index',
                            'crud' => 'image-groups',
                        ],
                        [
                            'name' => __('base::models.image-type.plural'),
                            'icon' => Base::icon('code', ['class' => 'h-6 w-6']),
                            'url' => 'image-types.index',
                            'crud' => 'image-types',
                        ],
                        [
                            'name' => __('base::models.image-size.plural'),
                            'icon' => Base::icon('template', ['class' => 'h-6 w-6']),
                            'url' => 'image-sizes.index',
                            'crud' => 'image-sizes',
                        ],
                    ],
                ],
                [
                    'name' => __('base::models.mail.plural'),
                    'icon' => Base::icon('mail', ['class' => 'h-6 w-6']),
                    'url' => 'mails.index',
                    'crud' => 'mails',
                ],
                [
                    'name' => __('base::app.config.plural'),
                    'icon' => Base::icon('cog', ['class' => 'h-6 w-6']),
                    'items' => [
                        [
                            'name' => __('base::models.key.plural'),
                            'icon' => Base::icon('puzzle', ['class' => 'h-6 w-6']),
                            'items' => [
                                [
                                    'name' => __('base::models.key.plural'),
                                    'icon' => Base::icon('code', ['class' => 'h-6 w-6']),
                                    'url' => 'keys.index',
                                    'crud' => 'keys',
                                ],
                                [
                                    'name' => __('base::models.key-group.plural'),
                                    'icon' => Base::icon('puzzle', ['class' => 'h-6 w-6']),
                                    'url' => 'key-groups.index',
                                    'crud' => 'key-groups',
                                ],
                            ],
                        ],
                    ],
                ],
            ];

            echo Base::menu($items);
        ?>
    </nav>
</div>
