<script setup lang="ts">

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Eye, Pencil, Trash2 } from 'lucide-vue-next';
import { Button, buttonVariants } from '@/components/ui/button';
import { deleteProduct } from '@/composables/useProduct';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];

defineProps<{ posts: Post[]}>();

</script>

<template>
    <Head title="Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-end">
                <Link :href="route('posts.create')" class="text-indigo-500 hover:text-indigo-700">
                    Create Post
                </Link>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

                <Table>
                    <TableCaption>A list of posts.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                ID
                            </TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Image</TableHead>
                            <TableHead>Content</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableCell class="font-medium">{{ post.id }}</TableCell>
                            <TableCell>{{ post.title }}</TableCell>
                            <TableCell>
                                <img :src="post.image" alt="post image" class="h-12 w-12 rounded object-cover" />
                            </TableCell>
                            <TableCell>{{ post.content }}</TableCell>
                            <TableCell class="text-right">
                                <Button variant="ghost"  size="icon" class="mr-2">
                                    <Link :href="route('posts.show', post.id)" class="text-blue-500 hover:text-blue-700" >
                                        <Eye class="inline-block mr-2" />
                                    </Link>
                                </Button>
                                <Button variant="ghost"  size="icon" class="mr-1">
                                    <Link :href="route('posts.edit', post.id)" class="text-indigo-500 hover:text-indigo-700">
                                        <Pencil class="inline-block mr-2" />
                                    </Link>
                                </Button>
                                <Button variant="destructive"  size="icon" >
                                    <Trash2  />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

            </div>
        </div>
    </AppLayout>
</template>
