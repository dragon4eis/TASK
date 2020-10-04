<template>
    <table class="table text-center">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Deadline</th>
            <th scope="col">
                <button class="btn btn-success" @click="addTask">Add</button>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="!tasks.length">
            <td colspan="4" class="text-danger" >No tasks added</td>
        </tr>
        <task-todo-create-task-row v-for="(task, index) in tasks" :key="index" v-model="tasks[index]"
                                   :index="index" @removeTask="removeTask($event)"></task-todo-create-task-row>
        </tbody>
    </table>
</template>

<script>
import TaskTodoCreateTaskRow from "./rows/CreateTaskRow";
export default {
    name: "task-todo-create-task-table",
    components: {TaskTodoCreateTaskRow},
    props:{
        value:{
            type:Array,
            required: true
        }
    },
    data(){
        return {
            tasks: this.value
        }
    },
    methods:{
        addTask() {
            this.tasks.push({title: "", deadline: moment().add(1, 'days').format('YYYY-MM-DD HH:mm:ss')})
        },
        removeTask(index) {
            this.tasks.splice(index,1)
        },
    },
    watch:{
        tasks(newValue, oldValue){
            if(newValue !== oldValue)
                this.$emit('input',newValue)
        },
        value(newValue){
            this.tasks = newValue
        }
    }
}
</script>

<style scoped>

</style>
