<template>
    <div class="container pt-5">
       <div class="row">
           <div class="col-md-8 pt-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <input class="form-control mr-sm-2" v-model="keyWord" type="search" placeholder="Blog Title" aria-label="Search">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success my-2 my-sm-0" @click="btnSearch" type="button">Search</button>
                    </div>
                    <div class="col-md-3 text-right">
                        <router-link to="/create" class="btn btn-success">Create Blog</router-link>
                    </div>
                </div>
                <div>
                    <h1>My Blog</h1>
                </div>
               <div v-for="blog in blogs" :key="blog.id" class="shadow-sm p-4 mb-3">
                   <div class="text-right">
                        <a id="navbarDropdown"  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" >
                             <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <router-link :to="{ path: '/edit/'+ blog.id}" class="dropdown-item">
                                Edit
                            </router-link>
                            <span style="cursor:pointer" class="dropdown-item" @click="btnDelete(blog.id)">
                                Delete
                            </span>
                        </div>
                   </div>
                   <img :src="blog.image == ''?'':'/storage/img/'+blog.image" class="img-fluid" alt="">
                   <strong>{{blog.title}}</strong>
                   <p>Desciption</p>
                   <p>
                       {{blog.description}}
                   </p>
               </div>
           </div>

           <div class="col-md-4 position-relative">
               
               <div class="row position-fixed p-5">
                   <div class="col-md-5">
                       <img src="/storage/img/user.png" class="img-fluid" alt="">
                   </div>
                   <div class="col-md-7">
                       <strong>Khenneth Alaiza</strong>
                       <p>
                           Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quos earum alias molestias illo aperiam libero sunt excepturi assumenda enim minima ipsam porro, repellendus cumque vel officia nihil adipisci fugit architecto?
                       </p>
                   </div>
               </div>
               
           </div>
       </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                blogs:{},
                keyWord:'',
                form: new Form({
                    id:''
                })
            }
        },
        methods:{
            loadBlog(){
                axios.get('/api/blog?api_token='+window.token)
                .then(response => {
                    this.blogs = response.data.blog;
                });
            },

            btnDelete(id){
                this.form.id = id;
                this.form.delete('api/blog/'+this.form.id+'?api_token='+window.token)
                .then(response => {
                    this.$router.push('deleted')
                });
            },
            btnSearch(){
                axios.post('api/search?api_token='+window.token,{keyWord:this.keyWord})
                .then(response => {
                    this.blogs = response.data.blog;
                });
            }
        },
        mounted() {
            this.loadBlog();
        }
    }
</script>
