webpackJsonp([8],{413:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=a(580),i=a(686),o=a(4);var r=function(e){a(684)},s=Object(o.a)(n.a,i.a,i.b,!1,r,"data-v-6769d0b0",null);t.default=s.exports},441:function(e,t,a){"use strict";var n=a(85),i=a.n(n);t.a={name:"singleImageUpload2",props:{value:String},computed:{imageUrl:function(){return this.value}},data:function(){return{tempUrl:""}},methods:{rmImage:function(){this.emitInput(""),this.emitValue("")},emitInput:function(e){this.$emit("input",e)},emitValue:function(e){this.$emit("value",e)},handleImageScucess:function(e,t,a){this.tempUrl=t.url,this.emitInput(this.tempUrl),this.emitValue(e.file)},myUpload:function(t){var e=new XMLHttpRequest,a=t.file;e.upload&&(e.upload.onprogress=function(e){0<e.total&&(e.percent=e.loaded/e.total*100),t.onProgress(e)});var n=new FormData;t.data&&i()(t.data).map(function(e){n.append(e,t.data[e])}),n.append(t.filename,t.file),e.onerror=function(e){t.onError(e)},e.onload=function(){if(e.status<200||300<=e.status)return t.onError(function(e,t,a){var n;n=a.response?a.status+(a.response.error||a.response):a.responseText?a.status+a.responseText:"fail to post "+e+a.status;var i=new Error(n);return i.status=a.status,i.method="post",i.url=e,i}(action,0,e));t.onSuccess(function(e){var t=e.responseText||e.response;if(!t)return t;try{var a=JSON.parse(t);return a.data}catch(e){return t}}(e))},e.open("post",t.action,!0),t.withCredentials&&"withCredentials"in e&&(e.withCredentials=!0),e.setRequestHeader("X-File-Name",encodeURIComponent(a.name)),e.setRequestHeader("X-File-Size",a.size),e.send(a)}}}},452:function(e,t,a){"use strict";var n=a(441),i=a(455),o=a(4);var r=function(e){a(453)},s=Object(o.a)(n.a,i.a,i.b,!1,r,"data-v-bbbde68e",null);t.a=s.exports},453:function(e,t,a){var n=a(454);"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);(0,a(24).default)("866e6b4a",n,!0,{})},454:function(e,t,a){(e.exports=a(19)(!1)).push([e.i,"\n.upload-container[data-v-bbbde68e] {\n  width: 50%;\n  height: 100%;\n  position: relative;\n}\n.upload-container .image-uploader[data-v-bbbde68e] {\n    height: 100%;\n}\n.upload-container .image-preview[data-v-bbbde68e] {\n    width: 100%;\n    height: 100%;\n    position: absolute;\n    left: 0px;\n    top: 0px;\n    border: 1px dashed #d9d9d9;\n}\n.upload-container .image-preview .image-preview-wrapper[data-v-bbbde68e] {\n      position: relative;\n      width: 100%;\n      height: 100%;\n}\n.upload-container .image-preview .image-preview-wrapper img[data-v-bbbde68e] {\n        width: 100%;\n        height: 100%;\n}\n.upload-container .image-preview .image-preview-action[data-v-bbbde68e] {\n      position: absolute;\n      width: 100%;\n      height: 100%;\n      left: 0;\n      top: 0;\n      cursor: default;\n      text-align: center;\n      color: #fff;\n      opacity: 0;\n      font-size: 20px;\n      background-color: rgba(0, 0, 0, 0.5);\n      transition: opacity 0.3s;\n      cursor: pointer;\n      text-align: center;\n      line-height: 200px;\n}\n.upload-container .image-preview .image-preview-action .el-icon-delete[data-v-bbbde68e] {\n        font-size: 36px;\n}\n.upload-container .image-preview:hover .image-preview-action[data-v-bbbde68e] {\n      opacity: 1;\n}\n",""])},455:function(e,t,a){"use strict";a.d(t,"a",function(){return n}),a.d(t,"b",function(){return i});var n=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"singleImageUpload2 upload-container"},[a("el-upload",{staticClass:"image-uploader",attrs:{drag:"",multiple:!1,"show-file-list":!1,action:"/v1/upload/image","on-success":e.handleImageScucess,"http-request":e.myUpload}},[a("i",{staticClass:"el-icon-upload"}),e._v(" "),a("div",{staticClass:"el-upload__text"},[e._v("Drag或"),a("em",[e._v("点击上传")])])]),e._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:0<e.imageUrl.length,expression:"imageUrl.length>0"}],staticClass:"image-preview"},[a("div",{directives:[{name:"show",rawName:"v-show",value:1<e.imageUrl.length,expression:"imageUrl.length>1"}],staticClass:"image-preview-wrapper"},[a("img",{attrs:{src:e.imageUrl}}),e._v(" "),a("div",{staticClass:"image-preview-action"},[a("i",{staticClass:"el-icon-delete",on:{click:e.rmImage}})])])])],1)},i=[]},543:function(e,t,a){"use strict";t.b=function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return n.a.get("/v1/setting/detail",e)},t.a=function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{},t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:null;return n.a.post("/v1/setting/create?identify="+t,e)};var n=a(30)},580:function(e,t,a){"use strict";var n=a(20),i=a.n(n),o=a(452),r=a(543),s=a(48);t.a={name:"SettingSystem",components:{Upload:o.a},data:function(){return{image:"",formData:{system_name:"",logo:""},loading:!1,listQuery:{identify:"_system"}}},computed:i()({},Object(s.b)(["setting"])),created:function(){this.getList()},methods:{getList:function(){var t=this;this.loading=!0,Object(r.b)(this.listQuery).then(function(e){Array.isArray(e.data)||(t.formData=e.data,t.image=t.setting.domain+t.formData.logo),t.loading=!1})},updateValue:function(e){this.formData.logo=e},submit:function(){var t=this;this.$refs.form.validate(function(e){e&&Object(r.a)(t.formData,"_system").then(function(e){t.$notify({title:t.$t("table.success"),message:t.$t("table.create_success_tips"),type:"success",duration:2e3})})})}}}},684:function(e,t,a){var n=a(685);"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);(0,a(24).default)("7f6b5448",n,!0,{})},685:function(e,t,a){(e.exports=a(19)(!1)).push([e.i,"\n.container[data-v-6769d0b0] {\n  position: relative;\n}\n.container .form-main-container[data-v-6769d0b0] {\n    padding: 40px 45px 20px 50px;\n}\n",""])},686:function(e,t,a){"use strict";a.d(t,"a",function(){return n}),a.d(t,"b",function(){return i});var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"container"},[a("el-form",{ref:"form",staticClass:"form-container",attrs:{model:t.formData}},[a("div",{staticClass:"form-main-container"},[a("el-form-item",{attrs:{"label-width":"80px",label:t.$t("form.system_name")}},[a("el-input",{staticClass:"input",attrs:{type:"text",autosize:"",placeholder:t.$t("form.placeholder_name")},model:{value:t.formData.system_name,callback:function(e){t.$set(t.formData,"system_name",e)},expression:"formData.system_name"}})],1),t._v(" "),a("el-form-item",{attrs:{"label-width":"80px",label:"LOGO"}},[a("Upload",{attrs:{value:t.formData.logo},on:{value:t.updateValue},model:{value:t.image,callback:function(e){t.image=e},expression:"image"}})],1),t._v(" "),a("el-button",{attrs:{type:"primary",icon:"el-icon-document"},on:{click:t.submit}},[t._v(t._s(t.$t("form.save")))])],1)])],1)},i=[]}});