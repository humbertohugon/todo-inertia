<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <form @submit.prevent="addTodo">
                <input type="text" v-model="newTodoTitle" placeholder="Nova Tarefa" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <button type="submit" class="mt-2 px-4 py-2 bg-indigo-500 text-white rounded-md shadow-md hover:bg-indigo-600">Adicionar Tarefa</button>
            </form>
        </template>

        <div class="py-12 w-full flex justify-center">
            <div class="w-1/4 sm:px-6 lg:px-8 space-y-2">
                <p class="text-xl font-bold text-center">
                    Todo: {{ todos.length }}
                </p>
                <draggable v-model="myTodos" class="space-y-2" group="mytodos" @start="drag = true" @end="done" id="todo"
                    item-key="id">
                    <template #item="{ element }">
                        <div class="bg-white overflow-hidden shadow-md sm:rounded-lg hover:cursor-pointer">
                            <div class="p-6 text-gray-900">{{ element.title }}</div>
                        </div>
                    </template>
                </draggable>


            </div>

            <div class="w-1/4 sm:px-6 lg:px-8 space-y-2">
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

<script>
import { ref } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import draggable from 'vuedraggable';
import axios from 'axios'; // Importe o axios para fazer requisições HTTP

export default {
    components: {
        AuthenticatedLayout,
        draggable
    },
    props: {
        todos: Array,
        done_todos: Array
    },
    setup(props) {
        const page = usePage();
        const myTodos = ref(props.todos);
        const myDoneTodos = ref(props.done_todos);
        const newTodoTitle = ref('');

        const done = (e) => {
            const movedElementId = e.item.__draggable_context.element.id;
            const from = e.from.id;
            const to = e.to.id;

            if (from == to) {
                return;
            }

            router.put(route('todo.toggle_status', movedElementId));
        };

        const addTodo = (columnType) => {
            const newTodo = {
                title: newTodoTitle.value,
                status: 'todo', // Definir o status inicial como 'todo'
                column_type: columnType // Passar o tipo de coluna onde a tarefa será adicionada (todo ou done)
            };

            axios.post('/api/todos', newTodo)
                .then(response => {
                    myTodos.value.push(response.data);
                    newTodoTitle.value = ''; // Limpar campo de entrada após adicionar tarefa
                })
                .catch(error => {
                    console.error('Erro ao adicionar tarefa:', error);
                });
        };

        return {
            Head,
            myTodos,
            myDoneTodos,
            newTodoTitle,
            done,
            addTodo
        };
    }
};
</script>
