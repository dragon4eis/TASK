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
            if(isReady){
                this.finishTask(task_id)
            } else {
                this.reopenTask(task_id)
            }
        },
        setDisabledState(isDisabled, task_id){
            if(isDisabled){
                this.disableTask(task_id)
            } else {
                this.enableTask(task_id)
            }
        },
        enableTask(task_id){
            axios.delete(`disabledTask/${task_id}`)
                .then((response) => {
                    this.$store.commit('todoLists/updateExistingResource', response.data.parent);
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg(error.response.data)
                })
        },
        disableTask(task_id){
            axios.post('disabledTask', {'task_id': task_id})
                .then((response) => {
                    this.$store.commit('todoLists/updateExistingResource', response.data.parent);
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg(error.response.data)
                })
        },
        finishTask(task_id){
            axios.post('readyTask', {'task_id': task_id})
                .then((response) => {
                    this.$store.commit('todoLists/updateExistingResource', response.data.parent);
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg(error.response.data)
                })
        },
        reopenTask(task_id){
            axios.delete(`readyTask/${task_id}`)
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
