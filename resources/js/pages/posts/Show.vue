<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
//import { deleteProduct } from '@/composables/useProduct'; // deletePost ???

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Show Post',
        href: '/posts',
    },
];

defineProps({
    post: {
        type: Object,
        required: true,
    }
});

</script>

<template>
    <Head title="Create Post" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div class="min-w-2xl mx-auto p-6 mt-8 ">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle>Post details</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">

                        <div class="flex flex-col gap-6">
                            <div class="grid gap-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-32 font-semibold">Title</div>
                                    <div>{{ post.title }}</div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-32 font-semibold">Content</div>
                                    <div>{{ post.content }}</div>

                                </div>
                                <div class="flex space-x-4">
                                    <div class="w-32 font-semibold">Image</div>
                                    <div v-if="post.image">
                                        <img :src="post.image" alt="Post Image" class="w-32 rounded" />
                                    </div>
                                    <div v-else>No Image for this post.</div>
                                </div>

                                <div class="flex justify-between items-center space-x-4 mt-6">
                                    <Link :href="route('posts.index')" :class="buttonVariants({variant: 'outline'})">Back</Link>
                                    <div>
                                        <Link :href="route('posts.edit', post)" :class="buttonVariants({variant: 'default'})">Edit</Link>
                                        <!--<Button class="ml-2" variant="destructive" @click="deletePost(post.id)">Delete</Button>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
