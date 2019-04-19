<template>
    <div>
        <div class="alert alert-primary text-center" v-if="processing">
            <i class="fa fa-compass">Procesando peticion</i>
            <v-server-table ref="table" :columns="columns" :url="url" :options="options">

            </v-server-table>

        </div>
    </div>

</template>


<script>
    // el event nos va a servir para poder emitir eventos al servidor, cuando queramos hacer alguna accion
    //por ej añadir un dropdown en el status para filtrar el estado(emitimos un evento)
    import {Event} from 'vue-tables-2';
    export default {
        name:'courses',
        //datos q se le van a pasar de entrada
        props:{
            labels:Object,
            required:true,

        },
        route:{
            type:String,
            required:true,

        },
        data(){
            return {
                processing:true,
                status:null,
                url:this.route,
                columns:['id','name','status','activate_deactivate'],
                options:{
                    filterByColumns:true,
                    perPage:10,
                    perPageValues:[10,25,40,50,100,500],
                    headings:{
                        id:'ID',
                        name:this.labels.name,
                        status:this.labels.status,
                        activate_deactivate:this.labels.activa_deactivate,
                        approve:this.labels.approve,
                        reject:this.labels.reject,


                    },
                    //filtros personalizados
                    //añadir un filtro perdonzalizado para la columna status
                    customFilters:['status'],
                    //ordenar por columna id nombre y status
                    sortable:['id','name','status'],
                    //introducir texto desde la columna name
                    filterable:['name'],
                    //nos devolvera una promesa
                    requestFunction: function(response){

                        return window.axios.get(url,{
                            params: response.data
                        })
                            .catch(function(e){
                                this.dispatch('error',e);

                            }.bind(this));
                    }

                }

            }
        }

    }

</script>

<style>

</style>