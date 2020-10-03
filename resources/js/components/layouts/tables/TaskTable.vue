<template>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Due</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <task-todo-task-row v-for="(task, index) in tasks" :key="index" :task="task" :index="index"></task-todo-task-row>
        </tbody>
    </table>
</template>

<script>
import TaskTodoTaskRow from "./rows/TaskRow";
export default {
    name: "task-todo-task-table",
    components: {TaskTodoTaskRow},
    props: {
        tasks:{
            type: Array,
            required: true
        },
    }
}
</script>

<style scoped>

</style>
