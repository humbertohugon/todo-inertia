<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import draggable from 'vuedraggable'

defineProps({
    todos: Array,
    done_todos: Array
})

const done = (e) => {
    // console.log(e);
    const movedElementId = e.item.__draggable_context.element.id
    // console.log(e)
    const from = e.from.id
    const to = e.to.id

    if (from == to) {
        return;
    }

    router.put(route('todo.toggle_status', movedElementId))
}

const page = usePage();

const myTodos = ref(page.props.todos);
const myDoneTodos = ref(page.props.done_todos);


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 w-full flex justify-center">
            <div class="w-1/4  sm:px-6 lg:px-8 space-y-2">

                <p class="text-xl font-bold text-center">
                    Todo: {{ todos.length }}
                </p>
                <draggable v-model="myTodos" class="space-y-2" group="mytodos" @start="drag = true" @end="done" id="todo"
                    item-key="id">
                    <template #item="{ element }">
                        <div class="bg-white overflow-hidden  shadow-md sm:rounded-lg hover:cursor-pointer">
                            <div class="p-6 text-gray-900">{{ element.title }}</div>
                        </div>

                    </template>
                </draggable>
            </div>



            <div class="w-1/4  sm:px-6 lg:px-8 space-y-2">
                <p class="text-xl font-bold text-center">
                    Done: {{ done_todos.length }}
                </p>

                <draggable v-model="myDoneTodos" id="done" class="space-y-2" group="mytodos" @start="drag = true"
                    @end="done" item-key="id">
                    <template #item="{ element }">
                        <div class="bg-green-200 overflow-hidden shadow-md sm:rounded-lg hover:cursor-pointer">
                            <div class="p-6 text-gray-900">{{ element.title }}</div>
                        </div>

                    </template>
                </draggable>

            </div>


        </div>
    </AuthenticatedLayout>
</template>
