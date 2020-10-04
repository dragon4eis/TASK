<template>
    <tr>
        <th  scope="row" v-text="index + 1"></th>
        <td>
            <input class="form-control" type="text" v-model="task.title"
                   :class="{'is-invalid': $store.getters['todoLists/hasError'](`tasks.${index}.title`)}"
                   @keydown="$store.commit('todoLists/clearError',`tasks.${index}.title`)"/>
            <div class="invalid-feedback d-block" v-if="$store.getters['todoLists/hasError'](`tasks.${index}.title`)">
                <strong v-text="$store.getters['todoLists/getError'](`tasks.${index}.title`).replace(`tasks.${index}.title`, `task ${index +1} title`)"></strong>
            </div>
        </td>
        <td>
            <!--                                    <input class="form-control" type="datetime-local"/>-->
            <el-date-picker v-model="task.deadline"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            :picker-options="{
                                                        disabledDate: disabledStartDate,
                                                        firstDayOfWeek: 1
                                                    }"
                            type="datetime"
                            clearable
                            format="dd.MM.yyyy HH:mm:ss"
                            :class="{'is-invalid': $store.getters['todoLists/hasError'](`tasks.${index}.deadline`)}"
                            @change="$store.commit('todoLists/clearError',`tasks.${index}.deadline`)">
            </el-date-picker>
            <div class="invalid-feedback d-block" v-if="$store.getters['todoLists/hasError'](`tasks.${index}.deadline`)">
                <strong v-text="$store.getters['todoLists/getError'](`tasks.${index}.deadline`).replace(`tasks.${index}.deadline`, `task ${index +1} deadline`)"></strong>
            </div>
        </td>
        <td>
            <button class="btn btn-danger" @click="$emit('removeTask',index)">Remove</button>
        </td>
    </tr>
</template>

<script>
export default {
    name: "task-todo-create-task-row",
    props:{
        value:{
            type:Object,
            required: true
        },
        index:{
            type: Number
        }
    },
    data(){
        return {
            task: {
                title: '',
                deadline: moment().add(1, 'days').format('YYYY-MM-DD HH:mm:ss')
            }
        }
    },
    methods:{
        disabledStartDate(date) {
            return !moment(date).isAfter(moment());
        },
    },
    mounted() {
        this.task = {...this.value}
    },
    watch:{
        task(newValue, oldValue){
            if(newValue !== oldValue)
                this.$emit('input',newValue)
        },
        value(newValue){
            this.task = newValue
        }
    }
}
</script>

<style scoped>

</style>
