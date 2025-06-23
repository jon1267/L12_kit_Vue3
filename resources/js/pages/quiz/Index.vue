<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
//import { Eye, Pencil, Trash2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { onMounted, ref, computed } from 'vue';
//import { toast } from 'vue-sonner';

import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quiz',
        href: '/quiz',
    },
];

const questions = ref([]);
const currentQuestionIndex = ref(0);
const loading = ref(false);

onMounted(() => {
    getQuestions()
});

const currentQuestion = computed(() => {
    return questions.value[currentQuestionIndex.value];
});

// time 11:30  lesson 2
//const randomAnswer = computed(() => {});

const getQuestions = async () => {
    loading.value = true;
    const resp = await axios.get('https://the-trivia-api.com/v2/questions');
    questions.value = resp.data;
    loading.value = false;
    console.log(resp.data);
};

</script>

<template>
    <Head title="Quiz" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

                <Card class="mx-auto mt-6 p-6 w-1/2" v-if="currentQuestion">
                    <CardHeader>
                        <CardTitle class="text-center">
                            <div class="flex justify-center text-xl space-x-5 mb-6">
                                <div class="flex justify-between w-full">
                                    <p>Duration:</p>
                                    <p>00:00</p>
                                </div>
                            </div>
                            <div class="flex justify-center text-xl space-x-10">
                                <div class="flex flex-col items-end w-1/4">
                                    <div class="flex justify-between w-full">
                                        <p>Total:</p>
                                        <p>10</p>
                                    </div>
                                    <div class="flex justify-between w-full">
                                        <p>Remaining:</p>
                                        <p>7</p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end w-1/4">
                                    <div class="flex justify-between text-green-700 w-full">
                                        <p>Correct:</p>
                                        <p>10</p>
                                    </div>
                                    <div class="flex justify-between text-red-600 w-full">
                                        <p>Incorrect:</p>
                                        <p>7</p>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xl mt-4">
                                {{ currentQuestion.question.text }}
                            </p>
                        </CardTitle>
                    </CardHeader>

                    <div class="flex flex-col justify-center space-y-6 mx-auto w-full md:w-1/2">
                        <button type="button" class="rounded-md font-medium transition-all bg-primary
                            text-primary-foreground shadow-xs hover:bg-primary/90 h-auto px-4 py-2 cursor-pointer" >
                            Lorem ipsum dolor
                        </button>
                        <button type="button" class="rounded-md font-medium transition-all bg-primary
                            text-primary-foreground shadow-xs hover:bg-primary/90 h-auto px-4 py-2 cursor-pointer" >
                            Lorem ipsum dolor
                        </button>
                        <button type="button" class="rounded-md font-medium transition-all bg-primary
                            text-primary-foreground shadow-xs hover:bg-primary/90 h-auto px-4 py-2 cursor-pointer" >
                            Lorem ipsum dolor
                        </button>
                        <button type="button" class="rounded-md font-medium transition-all bg-primary
                            text-primary-foreground shadow-xs hover:bg-primary/90 h-auto px-4 py-2 cursor-pointer" >
                            Lorem ipsum dolor
                        </button>
                    </div>
                </Card>

                <Card class="mx-auto mt-6 p-6 w-1/2" v-else>
                    <CardHeader>
                        <CardTitle class="text-center">
                            Congrats, here is your final score!
                            <p>100%</p>
                        </CardTitle>
                    </CardHeader>
                </Card>

            </div>
        </div>
    </AppLayout>
</template>

