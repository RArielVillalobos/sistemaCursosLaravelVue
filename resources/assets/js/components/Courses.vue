<template>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-6">
                <div class="input-group">
                    <select class="form-control col-md-3" v-model="criterio">
                        <option value="1">Publicado</option>
                        <option value="2">Pendiente</option>
                        <option value="3">Rechazado</option>

                    </select>
                    <input type="text"  v-on:keyup="listarCursos(1,buscar,criterio)" v-model="buscar" class="form-control" placeholder="Ingrese nombre del curso">
                    <button type="submit" v-on:click="listarCursos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th>Opciones</th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Estado</th>


                </tr>
                </thead>
                <tbody>
                <tr v-for="curso in arrayCursos" :key="curso.id">
                    <td v-text="curso.id"></td>
                    <td v-text="curso.name"></td>

                    <td  v-if="curso.status==1">Publicado</td>
                    <td v-else-if="curso.status==2">Pendiente</td>
                    <td v-else-if="curso.status==3">Rechazado</td>
                    <td>
                        <button v-if="curso.status==1" @click="updateStatus(curso,3)" type="button"  class="btn btn-danger btn-block">
                            Rechazar
                        </button>
                        <button v-else="curso.status==2" @click="updateStatus(curso,1)" type="button" class="btn btn-success btn-block">
                            Aprobar
                        </button>&nbsp;



                    </td>



                </tr>


                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination">
                <li class="page-item" v-if="pagination.curret_page>1">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                </li>
                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page === isActived ?'active' :'']">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page" ></a>
                </li>

                <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                criterio:1,
                buscar:'',
                arrayCursos:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0

                },
                offset:10


            }

            },

            computed:{
                isActived:function(){
                    return this.pagination.current_page;
                },
                pagesNumber:function () {
                    if (!this.pagination.to) {
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
                    if (to >= this.pagination.last_page) {
                        to = this.pagination.last_page;

                    }

                    var pagesArray = [];
                    while (from <= to) {
                        pagesArray.push(from);
                        from++;

                    }
                    return pagesArray;
                }

            },


            methods: {
                listarCursos(page,buscar,criterio) {
                    let me = this;
                    var url='/admin/courses_json?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                    axios.get(url).then(function (response) {
                        var respuesta=response.data;



                        // handle success
                        me.arrayCursos = respuesta.cursos.data;



                        me.pagination=respuesta.pagination;
                    })
                        .catch(function (error) {
                            // handle error

                            console.log(error);
                        });

                },
                cambiarPagina(page,buscar,criterio){
                    let me=this;

                    //Actualiza la pagina Actual
                    me.pagination.current_page=page;
                    //Envia la peticion para visualizar la data de esa pagina
                    me.listarCursos(page,buscar,criterio);
                },
                updateStatus(model,nuevoStatus){
                    let me=this;
                    var id=model.id;

                    axios.post('/admin/courses/updateStatus',{'id':id,'status':nuevoStatus}).then(function (response) {

                        me.listarCursos(1,'',1);
                        if(nuevoStatus==1){
                            swal({
                                title: "Curso aprobado correctamente!",
                                icon: "success",
                                button: "Continuar!",
                            });
                        }else{
                            swal({
                                title: "Curso rechazado correctamente!",
                                icon: "warning",
                                button: "Continuar!",
                            });
                        }


                    }).catch(function (error) {
                        console.log(error);

                    })

                }
            },
        mounted(){
            this.listarCursos(1,this.buscar,this.criterio);

        }
    }
</script>