<template>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Expires on</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <task-todo-task-row v-for="(task, index) in tasks" :key="index" :task="task" :index="index"
                            @ready="setReadyState($event, task.id)"
                            @disabled="setDisabledState($event,  task.id)"></task-todo-task-row>
        </tbody>
    </table>
</template>

<script>
import TaskTodoTaskRow from "./rows/TaskRow";

export default {
    name: "task-todo-task-table",
    components: {TaskTodoTaskRow},
    props: {
        tasks: {
            type: Array,
            required: true
        },
        todo_list_id:{
            required: true
        }
    },
    methods:{
        setReadyState(isReady, task_id){
            this.updateTask({ready: isReady}, task_id)
        },
        setDisabledState(isDisabled, task_id){
            this.updateTask({disabled: isDisabled}, task_id)
        },
        updateTask(task, task_id){
            axios.put(`todoList/${this.todo_list_id}/task/${task_id}`, task)
                .then((response) => {
                    this.$store.commit('todoLists/updateExistingResource', response.data.parent);
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg(error.response.data)
                })
        }
    }
}
</script>

<style scoped>

</style>
