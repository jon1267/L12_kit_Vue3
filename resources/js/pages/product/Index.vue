<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
//import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table';
import { Eye, Pencil, Trash2 } from 'lucide-vue-next';
import { Button, buttonVariants } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';


//const breadcrumbs: BreadcrumbItem[] = [
const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Products',
        href: '/products',
    },
];

//defineProps<{name?: string;}>();
defineProps({
    products: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <Card>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="p-4">Name</TableHead>
                            <TableHead class="p-4">Category</TableHead>
                            <TableHead class="p-4">Price</TableHead>
                            <TableHead class="p-4">Weight</TableHead>
                            <TableHead class="w-[120px]">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="product in products" :key="product.id">
                            <TableCell class="p-4">{{ product.name }}</TableCell>
                            <TableCell class="p-4">{{ product.category.name }}</TableCell>
                            <TableCell class="p-4">{{ product.price }}</TableCell>
                            <TableCell class="p-4">{{ product.weight }}</TableCell>
                            <TableCell className="space-x-1">
                                <Button variant="ghost"  size="icon" >
                                    <Link :href="route('products.show', product)" :class="buttonVariants({variant: 'secondary'})">
                                        <Eye className="h-4 w-4" />
                                    </Link>
                                </Button>
                                <Button variant="ghost"  size="icon">
                                    <Pencil className="h-4 w-4" />
                                </Button>
                                <Button variant="ghost"  size="icon">
                                    <Trash2 className="h-4 w-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
        </div>
    </AppLayout>
</template>
