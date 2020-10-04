import TodoListPage from "../../components/pages/TodoListPage";
import ListPreview from "../../components/layouts/ListPreview";
import TodoListCreatePanel from "../../components/layouts/TodoListCreatePanel";
import {makeRedirect} from "../config";
import DeleteTodoList from "../../components/layouts/DeleteTodoList";
import TodoListEditPanel from "../../components/layouts/TodoListEditPanel";

const storeModule = 'todo';

export default {
    path: 'todo',
    name: `${storeModule}-index`,
    redirect: makeRedirect(`${storeModule}-create`),
    component: TodoListPage,
    children:[
        {
            path: "create",
            name: `${storeModule}-create`,
            props: {
                default: true
            },
            components:{
                default: TodoListCreatePanel
            }
        },
        {
            path: ':todo_list_id(\\d+)',
            name: `${storeModule}-select`,
            props: {
                default: true
            },
            components:{
                default: ListPreview
            }
        },
        {
            path: ':todo_list_id(\\d+)/delete',
            name: `${storeModule}-delete`,
            props: {
                default: true
            },
            components:{
                default: DeleteTodoList
            }
        },
        {
            path: ':todo_list_id(\\d+)/edit',
            name: `${storeModule}-edit`,
            props: {
                default: true
            },
            components:{
                default: TodoListEditPanel
            }
        }
    ]
}
