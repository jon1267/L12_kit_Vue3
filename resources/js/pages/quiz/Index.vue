<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
//import { Eye, Pencil, Trash2 } from 'lucide-vue-next';
import { onMounted, ref, computed, watch } from 'vue';
//import { toast } from 'vue-sonner';

import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent  from '@/components/ui/card/CardContent.vue';
import Button from '@/components/ui/button/Button.vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quiz',
        href: '/quiz',
    },
];

const page = usePage();

const questions = ref([]);
const currentQuestionIndex = ref(0);
const loading = ref(false);
const correctScore = ref(0);
const incorrectScore = ref(0);
const completed = ref(false);

onMounted(() => {
    getQuestions()
});

const form = useForm({
    id: '',
    score: 0,
    start_time: '',
    end_time: '',
});

const currentQuestion = computed(() => {
    return questions.value[currentQuestionIndex.value];
});


const randomAnswer = computed(() => {
    return [
        currentQuestion.value.correctAnswer,
        ...currentQuestion.value.incorrectAnswers
    ].sort((a,b) => a < b ? -1 : 1);
    //.sort(() => Math.random() - 0.5);
});

const remainingCount = computed(() => {
    return questions.value.length - currentQuestionIndex.value;
});

const finalScore = computed(() => {
    return correctScore.value * 10;
});

// ??? Check if the quiz is completed
const hasCompleted = computed(() => {
    return completed.value = true ? remainingCount.value <= 0 : remainingCount.value >= 0
});

const user = computed(() => {
    return page.props.auth.user;
});

const getQuestions = async () => {
    loading.value = true;
    //const resp = await axios.get('https://the-trivia-api.com/v2/questions');
    //const resp = await axios.get('https://the-trivia-api.com/v2/questions?limit=10&categories=general_knowledge&difficulty=easy');
    const resp = await axios.get('https://the-trivia-api.com/v2/questions?limit=10&difficulty=medium');
    questions.value = resp.data;
    loading.value = false;
    console.log(resp.data);
};

const guess = (answer: any) => {
    if (currentQuestion.value.correctAnswer === answer) {
        correctScore.value++;
    } else {
        incorrectScore.value++;
    }
    currentQuestionIndex.value++;
};

const resetQuiz = () => {
    completed.value = false;
    questions.value = [];
    correctScore.value = 0;
    incorrectScore.value = 0;
    currentQuestionIndex.value = 0;
    getQuestions();
};

watch(currentQuestionIndex, (newIndex) => {
    if (newIndex === 10) {
        if (!user.value) {
            stop();
        } else {
            submit();
        }
    }
});

const stop = () => {
    form.score = correctScore.value;
};

const submit = () => {
    stop();
    form.post(route('quiz.stats.store'));
};
</script>

<template>
    <Head title="Quiz" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min"
                 :class="{'bg-[url(/storage/posts/celebration-19390_256.gif)] bg-no-repeat bg-cover' : hasCompleted }"
            >
                <Card class="mx-auto mt-6 p-6 w-1/2" v-if="currentQuestion">
                    <CardHeader>
                        <CardTitle class="text-center">
                            <div class="flex justify-center text-xl space-x-5 mb-6">
                                <div class="flex justify-between w-full">
                                    <p>Duration:</p>
                                    <p>00:00</p>
                                </div>
                            </div>

                            <!--<div class="flex justify-center text-xl space-x-10">-->
                            <div class="flex flex-col items-center text-xl space-y-5 lg:flex-row lg:justify-center lg:space-y-0 lg:space-x-10">
                                <div class="flex flex-col items-end w-1/4">
                                    <div class="flex justify-between space-x-5 w-full">
                                        <p>Total:</p>
                                        <p>{{ questions.length }}</p>
                                    </div>
                                    <div class="flex justify-between space-x-5 w-full">
                                        <p>Remain:</p>
                                        <p>{{ remainingCount }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end w-1/4">
                                    <div class="flex justify-between space-x-5 text-green-700 w-full">
                                        <p>Correct:</p>
                                        <p>{{ correctScore }}</p>
                                    </div>
                                    <div class="flex justify-between space-x-5 text-red-600 w-full">
                                        <p>Incorrect:</p>
                                        <p>{{ incorrectScore }}</p>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xl mt-4">
                                {{ currentQuestion.question.text }}
                            </p>
                        </CardTitle>
                    </CardHeader>

                    <div class="flex flex-col justify-center space-y-6 mx-auto w-full md:w-1/2">
                        <button  type="button"
                             class="rounded-md font-medium transition-all bg-primary text-primary-foreground shadow-xs hover:bg-primary/90 h-auto px-4 py-2 cursor-pointer"
                             v-for="(answer, index) in randomAnswer"
                             :key="index"
                            @click.prevent="guess(answer)"
                        >
                            {{ answer }}
                        </button>
                    </div>
                </Card>

                <Card class="mx-auto mt-6 p-6 w-1/2" v-else-if="loading">
                    <CardHeader>
                        <CardTitle class="text-center">
                            <p>...loading</p>
                        </CardTitle>
                    </CardHeader>
                </Card>

                <Card class="mx-auto mt-6 p-6 w-1/2" v-else>
                    <CardHeader>
                        <CardTitle class="text-center text-2xl">
                            <p>Congrats, here is your final score!</p>
                            <p>{{ finalScore }}%</p>
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="text-center">
                        <Button @click.prevent="resetQuiz" class="cursor-pointer">
                            Play Again!
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

