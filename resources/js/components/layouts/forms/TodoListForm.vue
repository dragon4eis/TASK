<template>
    <fieldset>
        <div class="form-group row required">
            <label class="col-sm-2 col-form-label" for="task-name">Title:</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="task-name" v-model="todo_list.title"
                       :class="{'is-invalid': $store.getters['todoLists/hasError']('title')}"
                       @keydown="$store.commit('todoLists/clearError','title')"/>
                <div class="invalid-feedback d-block" v-if="$store.getters['todoLists/hasError']('title')">
                    <strong v-text="$store.getters['todoLists/getError']('title')"></strong>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="task-name">Tasks:</label>
            <div class="col-sm-10">
                <task-todo-create-task-table v-model="todo_list.tasks"></task-todo-create-task-table>
            </div>
        </div>
    </fieldset>
</template>

<script>
import TaskTodoCreateTaskTable from "../tables/CreateTaskListTable";

export default {
    name: "todo-list-form",
    components: {TaskTodoCreateTaskTable},
    props:{
        value:{
            type: Object
        }
    },
    data(){
        return {
            todo_list: this.value
        }
    },
    watch:{
        todo_list(newValue, oldValue){
            if(newValue !== oldValue)
                this.$emit('input',newValue)
        },
        value(newValue){
            this.todo_list = newValue
        }
    }
}
</script>

<style scoped>

</style>
