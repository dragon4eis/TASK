<template>
    <div class="card">
        <div class="card-header">Preview</div>
        <div class="card-body" v-if="todo_list">
            <h3 v-text="todo_list.title" :class="{'text-success': todo_list.ready}"></h3>
            <task-todo-task-table :tasks="todo_list.tasks"></task-todo-task-table>
        </div>
        <div class="card-footer">
            <div class="btn-group  float-right">
                <!--                                <button  class="btn btn-primary">View</button>-->
                <button class="btn btn-secondary">Edit</button>
                <button class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
import TaskTodoTaskTable from "./tables/TaskTable";
export default {
    name: "task-todo-list-preview",
    components: {TaskTodoTaskTable},
    props:{
        todo_list_id:{
            required: true
        }
    },
    computed:{
        todo_list(){
            return this.$store.state.todoLists.resources.all.find(list => list.id === parseInt(this.todo_list_id)) || null
        }
    }
}
</script>

<style scoped>

</style>
