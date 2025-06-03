<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
//import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { deleteProduct } from '@/composables/useProduct.js'

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: 'Product Detail',
        href: '/products',
    },
];

defineProps({
    product: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Product Detail" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div class="flex w-full max-w-3xl flex-col">
                <Card class="mt-3">
                    <CardHeader>
                        <CardTitle>Product detail</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Name</div>
                            <div>{{ product.name}}</div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Category</div>
                            <div>{{ product.category.name}}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Brand</div>
                            <div>{{ product.brand}}</div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Price</div>
                            <div>$ {{ product.price / 100}}</div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-32 font-semibold">Weight</div>
                            <div>{{ product.weight}}</div>
                        </div>
                        <div class="flex space-x-4">
                            <div class="w-32 font-semibold">Image</div>
                            <div class="flex-1">
                                <img class="w-20" :src="product.image_url" v-if="product.image_url">
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <div class="w-32 font-semibold">Description</div>
                            <div class="flex-1">{{ product.description}}</div>
                        </div>

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <Link :href="route('products.index')" :class="buttonVariants({variant: 'outline'})">Back</Link>
                            <div>
                                <Link :href="route('products.edit', product)" :class="buttonVariants({variant: 'default'})">Edit</Link>
                                <Button class="ml-2" variant="destructive" @click="deleteProduct(product.id)">Delete</Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
