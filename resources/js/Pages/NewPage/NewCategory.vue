<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <card class="strpied-tabled-with-hover"
                body-classes="table-full-width table-responsive"
          >
            <template slot="header">
              <h4 class="card-title">اضافة دورة جديدة</h4>
            </template>
           <template slot="default">
               <div class="formis">
                   <div class="container">
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="name_ar">الاسم بالعربي</label>
                                   <input type="text" v-model="form.name_ar" class="form-control" id="name_ar">
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group"><label for="name_en">الاسم بالانجليزي</label>
                                    <input type="text" class="form-control" v-model="form.name_en" id="name_en">
                               </div>
                           </div>
                       </div>
                       <div style="height:20px;"></div>
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                    <label for="description_ar">الوصف بالعربي</label>
                                    <textarea name="description_ar" id="description_ar" v-model="form.description_ar" class="form-control" rows="5"></textarea>
                               </div>
                               
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                    <label for="description_en">الوصف بالانجليزي</label>
                                    <textarea id="description_en" rows="5" class="form-control" v-model="form.description_en"></textarea>
                               </div>
                               
                           </div>
                       </div>
                       <div style="height:20px;"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-info btn-block btn-lg" @click="openImage">ارفاق الصورة</button>
                                    <div class="fileInput">
                                        <input type="file" v-on:change="onFileChange" ref="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="error">
                            <div class="col-md-12">
                                <div class="error">
                                    يوجد خطا في الحقول الرجاء التاكد منها جميعا 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button class="btn btn-success btn-block" @click="store">حفظ المعلومات</button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                   </div>
               </div>
           </template>
          </card>
        </div>
      </div>
    </div>
    <loader v-if="show_loader" />
  </div>
</template>
<script>
  import Card from '../../components/Cards/Card.vue'
  import loader from '../../components/loader.vue';
  export default {
    components: {
      Card,
      loader
    },
    data () {
      return {
          form:{},
          show_loader:false,
          error:false
      }
    },
    methods: {
        onFileChange(e) {
        let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
            return;
        this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.form.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        openImage() {
            const vm = this;
            vm.$refs.image.click();
        },
        store() {
            const vm = this;
            vm.show_loader = true;
            vm.error = false;

            axios.post('admin/shop_category/store',vm.form).then(response => {
                vm.show_loader = false;
                vm.error = false;
                confirm('Added Success') && 

                location.reload();
            }).catch(err => {
                console.log(err.response)
                vm.show_loader = false;
                vm.error = true;
            });
        }
    }
  }
</script>
<style scoped>
.fileInput{position: fixed; left:-99999px;}
.error{color:red;font-weight: 700;}
</style>
