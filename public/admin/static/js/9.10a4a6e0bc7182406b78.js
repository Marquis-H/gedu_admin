webpackJsonp([9],{414:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=a(581),n=a(689),r=a(4);var o=function(t){a(687)},s=Object(r.a)(i.a,n.a,n.b,!1,o,"data-v-2e6aa4aa",null);e.default=s.exports},441:function(t,e,a){"use strict";var i=a(85),n=a.n(i);e.a={name:"singleImageUpload2",props:{value:String},computed:{imageUrl:function(){return this.value}},data:function(){return{tempUrl:"",action:"https://gedu.qidorg.com/v1/upload/image"}},methods:{rmImage:function(){this.emitInput(""),this.emitValue("")},emitInput:function(t){this.$emit("input",t)},emitValue:function(t){this.$emit("value",t)},handleImageScucess:function(t,e,a){this.tempUrl=e.url,this.emitInput(this.tempUrl),this.emitValue(t.file)},myUpload:function(e){var t=new XMLHttpRequest,a=e.file;t.upload&&(t.upload.onprogress=function(t){0<t.total&&(t.percent=t.loaded/t.total*100),e.onProgress(t)});var i=new FormData;e.data&&n()(e.data).map(function(t){i.append(t,e.data[t])}),i.append(e.filename,e.file),t.onerror=function(t){e.onError(t)},t.onload=function(){if(t.status<200||300<=t.status)return e.onError(function(t,e,a){var i;i=a.response?a.status+(a.response.error||a.response):a.responseText?a.status+a.responseText:"fail to post "+t+a.status;var n=new Error(i);return n.status=a.status,n.method="post",n.url=t,n}(action,0,t));e.onSuccess(function(t){var e=t.responseText||t.response;if(!e)return e;try{var a=JSON.parse(e);return a.data}catch(t){return e}}(t))},t.open("post",e.action,!0),e.withCredentials&&"withCredentials"in t&&(t.withCredentials=!0),t.setRequestHeader("X-File-Name",encodeURIComponent(a.name)),t.setRequestHeader("X-File-Size",a.size),t.send(a)}}}},452:function(t,e,a){"use strict";var i=a(441),n=a(455),r=a(4);var o=function(t){a(453)},s=Object(r.a)(i.a,n.a,n.b,!1,o,"data-v-1bd19ec2",null);e.a=s.exports},453:function(t,e,a){var i=a(454);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,a(24).default)("883aa9fc",i,!0,{})},454:function(t,e,a){(t.exports=a(19)(!1)).push([t.i,"\n.upload-container[data-v-1bd19ec2] {\n  width: 50%;\n  height: 100%;\n  position: relative;\n}\n.upload-container .image-uploader[data-v-1bd19ec2] {\n    height: 100%;\n}\n.upload-container .image-preview[data-v-1bd19ec2] {\n    width: 100%;\n    height: 100%;\n    position: absolute;\n    left: 0px;\n    top: 0px;\n    border: 1px dashed #d9d9d9;\n}\n.upload-container .image-preview .image-preview-wrapper[data-v-1bd19ec2] {\n      position: relative;\n      width: 100%;\n      height: 100%;\n}\n.upload-container .image-preview .image-preview-wrapper img[data-v-1bd19ec2] {\n        width: 100%;\n        height: 100%;\n}\n.upload-container .image-preview .image-preview-action[data-v-1bd19ec2] {\n      position: absolute;\n      width: 100%;\n      height: 100%;\n      left: 0;\n      top: 0;\n      cursor: default;\n      text-align: center;\n      color: #fff;\n      opacity: 0;\n      font-size: 20px;\n      background-color: rgba(0, 0, 0, 0.5);\n      transition: opacity 0.3s;\n      cursor: pointer;\n      text-align: center;\n      line-height: 200px;\n}\n.upload-container .image-preview .image-preview-action .el-icon-delete[data-v-1bd19ec2] {\n        font-size: 36px;\n}\n.upload-container .image-preview:hover .image-preview-action[data-v-1bd19ec2] {\n      opacity: 1;\n}\n",""])},455:function(t,e,a){"use strict";a.d(e,"a",function(){return i}),a.d(e,"b",function(){return n});var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"singleImageUpload2 upload-container"},[a("el-upload",{staticClass:"image-uploader",attrs:{drag:"",multiple:!1,"show-file-list":!1,action:t.action,"on-success":t.handleImageScucess,"http-request":t.myUpload}},[a("i",{staticClass:"el-icon-upload"}),t._v(" "),a("div",{staticClass:"el-upload__text"},[t._v("Drag或"),a("em",[t._v("点击上传")])])]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:0<t.imageUrl.length,expression:"imageUrl.length>0"}],staticClass:"image-preview"},[a("div",{directives:[{name:"show",rawName:"v-show",value:1<t.imageUrl.length,expression:"imageUrl.length>1"}],staticClass:"image-preview-wrapper"},[a("img",{attrs:{src:t.imageUrl}}),t._v(" "),a("div",{staticClass:"image-preview-action"},[a("i",{staticClass:"el-icon-delete",on:{click:t.rmImage}})])])])],1)},n=[]},543:function(t,e,a){"use strict";e.b=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/setting/detail",t)},e.a=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{},e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:null;return i.a.post("/v1/setting/create?identify="+e,t)};var i=a(30)},581:function(t,e,a){"use strict";var i=a(452),n=a(543);e.a={name:"SettingFrontend",components:{Upload:i.a},data:function(){return{image:"",formData:{website_name:"",page_title_format:"",website_keywords:"",website_description:"",custom_style:"",share_integral:0,share_reg_integral:0,each_day_integral:0,word_integral:0},loading:!1,listQuery:{identify:"_frontend"}}},created:function(){this.getList()},methods:{getList:function(){var e=this;this.loading=!0,Object(n.b)(this.listQuery).then(function(t){Array.isArray(t.data)||(e.formData=t.data,e.image=e.formData.logo),e.loading=!1})},updateValue:function(t){this.formData.logo=t},submit:function(){var e=this;this.$refs.form.validate(function(t){t&&Object(n.a)(e.formData,"_frontend").then(function(t){e.$notify({title:e.$t("table.success"),message:e.$t("table.update_success_tips"),type:"success",duration:2e3})})})}}}},687:function(t,e,a){var i=a(688);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,a(24).default)("4ad25312",i,!0,{})},688:function(t,e,a){(t.exports=a(19)(!1)).push([t.i,"\n.container[data-v-2e6aa4aa] {\n  position: relative;\n}\n.container .form-main-container[data-v-2e6aa4aa] {\n    padding: 40px 45px 20px 50px;\n}\n.container .page_title_format_tips[data-v-2e6aa4aa] {\n    padding: 0;\n    margin-top: 8px;\n}\n",""])},689:function(t,e,a){"use strict";a.d(e,"a",function(){return i}),a.d(e,"b",function(){return n});var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"container"},[a("el-form",{ref:"form",staticClass:"form-container",attrs:{model:e.formData}},[a("div",{staticClass:"form-main-container"},[a("el-form-item",{attrs:{"label-width":"120px",label:e.$t("form.website_name")}},[a("el-input",{staticClass:"input",attrs:{type:"text",autosize:"",placeholder:e.$t("form.placeholder_name")},model:{value:e.formData.system_name,callback:function(t){e.$set(e.formData,"system_name",t)},expression:"formData.system_name"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:e.$t("form.page_title_format")}},[a("el-input",{staticClass:"input",attrs:{type:"text",autosize:"",placeholder:e.$t("form.placeholder_name")},model:{value:e.formData.page_title_format,callback:function(t){e.$set(e.formData,"page_title_format",t)},expression:"formData.page_title_format"}}),e._v(" "),a("el-alert",{staticClass:"page_title_format_tips",attrs:{title:e.$t("form.page_title_format_tips"),type:"success",closable:!1}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:e.$t("form.website_keywords")}},[a("el-input",{staticClass:"input",attrs:{type:"text",autosize:"",placeholder:e.$t("form.placeholder_name")},model:{value:e.formData.website_keywords,callback:function(t){e.$set(e.formData,"website_keywords",t)},expression:"formData.website_keywords"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:e.$t("form.website_description")}},[a("el-input",{attrs:{rows:5,type:"textarea",placeholder:e.$t("form.placeholder_name")},model:{value:e.formData.website_description,callback:function(t){e.$set(e.formData,"website_description",t)},expression:"formData.website_description"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:e.$t("form.custom_style")}},[a("el-input",{attrs:{rows:5,type:"textarea",placeholder:e.$t("form.placeholder_name")},model:{value:e.formData.custom_style,callback:function(t){e.$set(e.formData,"custom_style",t)},expression:"formData.custom_style"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:"分享积分"}},[a("el-input",{staticClass:"input",attrs:{type:"number",autosize:""},model:{value:e.formData.share_integral,callback:function(t){e.$set(e.formData,"share_integral",t)},expression:"formData.share_integral"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:"分享注册积分"}},[a("el-input",{staticClass:"input",attrs:{type:"number",autosize:""},model:{value:e.formData.share_reg_integral,callback:function(t){e.$set(e.formData,"share_reg_integral",t)},expression:"formData.share_reg_integral"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:"单词打卡积分"}},[a("el-input",{staticClass:"input",attrs:{type:"number",autosize:""},model:{value:e.formData.word_integral,callback:function(t){e.$set(e.formData,"word_integral",t)},expression:"formData.word_integral"}})],1),e._v(" "),a("el-form-item",{attrs:{"label-width":"120px",label:"每天积分上限"}},[a("el-input",{staticClass:"input",attrs:{type:"number",autosize:""},model:{value:e.formData.each_day_integral,callback:function(t){e.$set(e.formData,"each_day_integral",t)},expression:"formData.each_day_integral"}}),e._v(" "),a("el-alert",{staticClass:"page_title_format_tips",attrs:{title:"上限积分=分享积分+分享注册积分",type:"success",closable:!1}})],1),e._v(" "),a("el-button",{attrs:{type:"primary",icon:"el-icon-document"},on:{click:e.submit}},[e._v(e._s(e.$t("form.save")))])],1)])],1)},n=[]}});