@extends('admin::layouts.master')

@section('title', '角色管理')

@section('content')
  <div id="app" class="card" v-cloak>
    <div class="card-body h-min-600">
      <el-form ref="form" :rules="rules" :model="form" label-width="100px" class="w-max-700">
        <el-form-item label="角色名称" prop="name">
          <el-input v-model="form.name" placeholder="角色名称"></el-input>
        </el-form-item>

        <el-form-item label="权限" prop="roles">
          <div class="roles-wrap border">
            <div class="header-wrap bg-dark p-2 text-dark bg-opacity-10 px-2">
              <el-button size="small" @click="updateAllState(true)">选中所有</el-button>
              <el-button size="small" @click="updateAllState(false)">取消选中</el-button>
            </div>
            <div v-for="role, index in form.permissions" :key="index">
              <div class="bg-light px-2 d-flex">
                @{{ role.title }}
                <div class="row-update ms-2 link-secondary">[<span @click="updateState(true, index)">全选</span> / <span @click="updateState(false, index)">取消</span>]</div>
              </div>
              <div class="role.methods">
                <div class="d-flex px-3">
                  <div v-for="method,index in role.permissions" class="me-3">
                    <el-checkbox class="text-dark" v-model="method.selected">@{{ method.name }}</el-checkbox>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </el-form-item>

        <el-form-item class="mt-5">
          <el-button type="primary" @click="addFormSubmit('form')">保存</el-button>
          <el-button @click="closeCustomersDialog('form')">取消</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
@endsection

@push('footer')
  <script>
    new Vue({
      el: '#app',

      data: {
        form: {
          id: @json($role->id ?? null),
          name: @json($role->name ?? ''),
          permissions: @json($permissions ?? []),
        },

        source: {

        },

        rules: {
          name: [{required: true,message: '请输入角色名称',trigger: 'blur'}, ],
          description: [{required: true,message: '请输入描述',trigger: 'blur'}, ],
        }
      },

      beforeMount() {
        // this.source.languages.forEach(e => {
        //   this.$set(this.form.name, e.code, '')
        //   this.$set(this.form.description, e.code, '')
        // })
      },

      methods: {
        updateState(type, index) {
          this.form.permissions[index].permissions.map(e => e.selected = !!type)
        },

        updateAllState(type) {
          this.form.permissions.forEach(e => {
            e.permissions.forEach(method => {
              method.selected = !!type
            });
          });
        },

        addFormSubmit(form) {
          const self = this;
          const type = this.form.id == null ? 'post' : 'put';
          const url = this.form.id == null ? 'admin_roles' : 'admin_roles/' + this.form.id;

          this.$refs[form].validate((valid) => {
            // this.form.permissions.forEach(e => {
            //   e.permissions = e.permissions.filter(x => x.selected).map(j => j.code)
            // });

            if (!valid) {
              this.$message.error('请检查表单是否填写正确');
              return;
            }

            $http[type](url, this.form).then((res) => {
              this.$message.success(res.message);
            })
          });
        },
      }
    })
  </script>

  <style>
    .roles-wrap .el-checkbox.text-dark .el-checkbox__label {
      font-size: 12px;
      padding-left: 6px;
    }

    .row-update {
      cursor: pointer;
      font-size: 12px;
    }
  </style>
@endpush