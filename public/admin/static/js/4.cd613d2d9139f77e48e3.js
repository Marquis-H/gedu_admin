webpackJsonp([4],{417:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n(584),i=n(692),o=n(4),r=Object(o.a)(a.a,i.a,i.b,!1,null,null,null);e.default=r.exports},441:function(t,e,n){"use strict";var a=n(85),i=n.n(a);e.a={name:"singleImageUpload2",props:{value:String},computed:{imageUrl:function(){return this.value}},data:function(){return{tempUrl:"",action:"https://gedu.qidorg.com/v1/upload/image"}},methods:{rmImage:function(){this.emitInput(""),this.emitValue("")},emitInput:function(t){this.$emit("input",t)},emitValue:function(t){this.$emit("value",t)},handleImageScucess:function(t,e,n){this.tempUrl=e.url,this.emitInput(this.tempUrl),this.emitValue(t.file)},myUpload:function(e){var t=new XMLHttpRequest,n=e.file;t.upload&&(t.upload.onprogress=function(t){0<t.total&&(t.percent=t.loaded/t.total*100),e.onProgress(t)});var a=new FormData;e.data&&i()(e.data).map(function(t){a.append(t,e.data[t])}),a.append(e.filename,e.file),t.onerror=function(t){e.onError(t)},t.onload=function(){if(t.status<200||300<=t.status)return e.onError(function(t,e,n){var a;a=n.response?n.status+(n.response.error||n.response):n.responseText?n.status+n.responseText:"fail to post "+t+n.status;var i=new Error(a);return i.status=n.status,i.method="post",i.url=t,i}(action,0,t));e.onSuccess(function(t){var e=t.responseText||t.response;if(!e)return e;try{var n=JSON.parse(e);return n.data}catch(t){return e}}(t))},t.open("post",e.action,!0),e.withCredentials&&"withCredentials"in t&&(t.withCredentials=!0),t.setRequestHeader("X-File-Name",encodeURIComponent(n.name)),t.setRequestHeader("X-File-Size",n.size),t.send(n)}}}},452:function(t,e,n){"use strict";var a=n(441),i=n(455),o=n(4);var r=function(t){n(453)},s=Object(o.a)(a.a,i.a,i.b,!1,r,"data-v-1bd19ec2",null);e.a=s.exports},453:function(t,e,n){var a=n(454);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("883aa9fc",a,!0,{})},454:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.upload-container[data-v-1bd19ec2] {\n  width: 50%;\n  height: 100%;\n  position: relative;\n}\n.upload-container .image-uploader[data-v-1bd19ec2] {\n    height: 100%;\n}\n.upload-container .image-preview[data-v-1bd19ec2] {\n    width: 100%;\n    height: 100%;\n    position: absolute;\n    left: 0px;\n    top: 0px;\n    border: 1px dashed #d9d9d9;\n}\n.upload-container .image-preview .image-preview-wrapper[data-v-1bd19ec2] {\n      position: relative;\n      width: 100%;\n      height: 100%;\n}\n.upload-container .image-preview .image-preview-wrapper img[data-v-1bd19ec2] {\n        width: 100%;\n        height: 100%;\n}\n.upload-container .image-preview .image-preview-action[data-v-1bd19ec2] {\n      position: absolute;\n      width: 100%;\n      height: 100%;\n      left: 0;\n      top: 0;\n      cursor: default;\n      text-align: center;\n      color: #fff;\n      opacity: 0;\n      font-size: 20px;\n      background-color: rgba(0, 0, 0, 0.5);\n      transition: opacity 0.3s;\n      cursor: pointer;\n      text-align: center;\n      line-height: 200px;\n}\n.upload-container .image-preview .image-preview-action .el-icon-delete[data-v-1bd19ec2] {\n        font-size: 36px;\n}\n.upload-container .image-preview:hover .image-preview-action[data-v-1bd19ec2] {\n      opacity: 1;\n}\n",""])},455:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"singleImageUpload2 upload-container"},[n("el-upload",{staticClass:"image-uploader",attrs:{drag:"",multiple:!1,"show-file-list":!1,action:t.action,"on-success":t.handleImageScucess,"http-request":t.myUpload}},[n("i",{staticClass:"el-icon-upload"}),t._v(" "),n("div",{staticClass:"el-upload__text"},[t._v("Drag或"),n("em",[t._v("点击上传")])])]),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:0<t.imageUrl.length,expression:"imageUrl.length>0"}],staticClass:"image-preview"},[n("div",{directives:[{name:"show",rawName:"v-show",value:1<t.imageUrl.length,expression:"imageUrl.length>1"}],staticClass:"image-preview-wrapper"},[n("img",{attrs:{src:t.imageUrl}}),t._v(" "),n("div",{staticClass:"image-preview-action"},[n("i",{staticClass:"el-icon-delete",on:{click:t.rmImage}})])])])],1)},i=[]},456:function(t,e,n){"use strict";e.a={name:"Sticky",props:{stickyTop:{type:Number,default:0},zIndex:{type:Number,default:1},className:{type:String}},data:function(){return{active:!1,position:"",width:void 0,height:void 0,isSticky:!1}},mounted:function(){this.height=this.$el.getBoundingClientRect().height,window.addEventListener("scroll",this.handleScroll),window.addEventListener("resize",this.handleReize)},activated:function(){this.handleScroll()},destroyed:function(){window.removeEventListener("scroll",this.handleScroll),window.removeEventListener("resize",this.handleReize)},methods:{sticky:function(){this.active||(this.position="fixed",this.active=!0,this.width=this.width+"px",this.isSticky=!0)},reset:function(){this.active&&(this.position="",this.width="auto",this.active=!1,this.isSticky=!1)},handleScroll:function(){this.width=this.$el.getBoundingClientRect().width,this.$el.getBoundingClientRect().top<this.stickyTop?this.sticky():this.reset()},handleReize:function(){this.isSticky&&(this.width=this.$el.getBoundingClientRect().width+"px")}}}},460:function(t,e,n){"use strict";var a=n(20),i=n.n(a),o=n(480),r=n(484),s=n(485),l=n(48);e.a={name:"tinymce",components:{editorImage:o.a},props:{id:{type:String},value:{type:String,default:""},toolbar:{type:Array,required:!1,default:function(){return[]}},menubar:{default:"file edit insert view format table"},height:{type:Number,required:!1,default:360}},data:function(){return{hasChange:!1,hasInit:!1,tinymceId:this.id||"vue-tinymce-"+ +new Date,fullscreen:!1}},computed:i()({},Object(l.b)(["setting"])),watch:{value:function(t){var e=this;!this.hasChange&&this.hasInit&&this.$nextTick(function(){return window.tinymce.get(e.tinymceId).setContent(t||"")})}},mounted:function(){this.initTinymce()},activated:function(){this.initTinymce()},deactivated:function(){this.destroyTinymce()},methods:{initTinymce:function(){var e=this,n=this;window.tinymce.init({language:"zh_CN",selector:"#"+this.tinymceId,height:this.height,body_class:"panel-body ",object_resizing:!1,toolbar:0<this.toolbar.length?this.toolbar:s.a,menubar:this.menubar,plugins:r.a,end_container_on_empty_block:!0,powerpaste_word_import:"clean",code_dialog_height:450,code_dialog_width:1e3,advlist_bullet_styles:"square",advlist_number_styles:"default",imagetools_cors_hosts:["www.tinymce.com","codepen.io"],default_link_target:"_blank",link_title:!1,nonbreaking_force_tab:!0,init_instance_callback:function(t){n.value&&t.setContent(n.value),n.hasInit=!0,t.on("NodeChange Change KeyUp SetContent",function(){e.hasChange=!0,e.$emit("input",t.getContent())})},setup:function(t){t.on("FullscreenStateChanged",function(t){n.fullscreen=t.state})}})},destroyTinymce:function(){window.tinymce.get(this.tinymceId)&&window.tinymce.get(this.tinymceId).destroy()},setContent:function(t){window.tinymce.get(this.tinymceId).setContent(t)},getContent:function(){window.tinymce.get(this.tinymceId).getContent()},imageSuccessCBK:function(t){var n=this,a=this;t.forEach(function(t){var e=n.setting.domain+t.url;window.tinymce.get(a.tinymceId).insertContent('<img class="wscnph" src="'+e+'" >')})}},destroyed:function(){this.destroyTinymce()}}},461:function(t,e,n){"use strict";var a=n(50),s=n.n(a),i=n(85),r=n.n(i);e.a={name:"editorSlideUpload",props:{color:{type:String,default:"#1890ff"}},data:function(){return{dialogVisible:!1,listObj:{},fileList:[]}},methods:{checkAllSuccess:function(){var e=this;return r()(this.listObj).every(function(t){return e.listObj[t].hasSuccess})},handleSubmit:function(){var e=this,t=r()(this.listObj).map(function(t){return e.listObj[t]});this.checkAllSuccess()?(this.$emit("successCBK",t),this.listObj={},this.fileList=[],this.dialogVisible=!1):this.$message("请等待所有图片上传成功 或 出现了网络问题，请刷新页面重新上传！")},handleSuccess:function(t,e){for(var n=e.uid,a=r()(this.listObj),i=0,o=a.length;i<o;i++)if(this.listObj[a[i]].uid===n)return this.listObj[a[i]].url=t.file,void(this.listObj[a[i]].hasSuccess=!0)},handleRemove:function(t){for(var e=t.uid,n=r()(this.listObj),a=0,i=n.length;a<i;a++)if(this.listObj[n[a]].uid===e)return void delete this.listObj[n[a]]},beforeUpload:function(a){var i=this,o=window.URL||window.webkitURL,r=a.uid;return this.listObj[r]={},new s.a(function(t,e){var n=new Image;n.src=o.createObjectURL(a),n.onload=function(){i.listObj[r]={hasSuccess:!1,uid:a.uid,width:this.width,height:this.height}},t(!0)})},myUpload:function(e){var t=new XMLHttpRequest,n=e.file;t.upload&&(t.upload.onprogress=function(t){0<t.total&&(t.percent=t.loaded/t.total*100),e.onProgress(t)});var a=new FormData;e.data&&r()(e.data).map(function(t){a.append(t,e.data[t])}),a.append(e.filename,e.file),t.onerror=function(t){e.onError(t)},t.onload=function(){if(t.status<200||300<=t.status)return e.onError(function(t,e,n){var a;a=n.response?n.status+(n.response.error||n.response):n.responseText?n.status+n.responseText:"fail to post "+t+n.status;var i=new Error(a);return i.status=n.status,i.method="post",i.url=t,i}(action,0,t));e.onSuccess(function(t){var e=t.responseText||t.response;if(!e)return e;try{var n=JSON.parse(e);return n.data}catch(t){return e}}(t))},t.open("post",e.action,!0),e.withCredentials&&"withCredentials"in t&&(t.withCredentials=!0),t.setRequestHeader("X-File-Name",encodeURIComponent(n.name)),t.setRequestHeader("X-File-Size",n.size),t.send(n)}}}},465:function(t,e,n){"use strict";var a=n(456),i=n(466),o=n(4),r=Object(o.a)(a.a,i.a,i.b,!1,null,null,null);e.a=r.exports},466:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{style:{height:t.height+"px",zIndex:t.zIndex}},[n("div",{class:t.className,style:{top:t.stickyTop+"px",zIndex:t.zIndex,position:t.position,width:t.width,height:t.height+"px"}},[t._t("default",[n("div",[t._v("sticky")])])],2)])},i=[]},477:function(t,e,n){"use strict";var a=n(460),i=n(486),o=n(4);var r=function(t){n(478)},s=Object(o.a)(a.a,i.a,i.b,!1,r,"data-v-1428fa49",null);e.a=s.exports},478:function(t,e,n){var a=n(479);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("84ac9d2e",a,!0,{})},479:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.tinymce-container[data-v-1428fa49] {\n  position: relative;\n}\n.tinymce-container[data-v-1428fa49] .mce-fullscreen {\n  z-index: 10000;\n}\n.tinymce-textarea[data-v-1428fa49] {\n  visibility: hidden;\n  z-index: -1;\n}\n.editor-custom-btn-container[data-v-1428fa49] {\n  position: absolute;\n  right: 4px;\n  top: 4px;\n  line-height: 0;\n  /*z-index: 2005;*/\n}\n.fullscreen .editor-custom-btn-container[data-v-1428fa49] {\n  z-index: 10000;\n  position: fixed;\n}\n.editor-upload-btn[data-v-1428fa49] {\n  display: inline-block;\n  line-height: 0;\n}\n",""])},480:function(t,e,n){"use strict";var a=n(461),i=n(483),o=n(4);var r=function(t){n(481)},s=Object(o.a)(a.a,i.a,i.b,!1,r,"data-v-f6ff36a2",null);e.a=s.exports},481:function(t,e,n){var a=n(482);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("3cb134b2",a,!0,{})},482:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.editor-slide-upload[data-v-f6ff36a2] {\n  margin-bottom: 20px;\n}\n.editor-slide-upload[data-v-f6ff36a2] .el-upload--picture-card {\n    width: 100%;\n}\n",""])},483:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"upload-container"},[n("el-button",{style:{background:e.color,borderColor:e.color},attrs:{icon:"el-icon-upload",size:"mini",type:"primary"},on:{click:function(t){e.dialogVisible=!0}}},[e._v("上传图片\n  ")]),e._v(" "),n("el-dialog",{attrs:{visible:e.dialogVisible},on:{"update:visible":function(t){e.dialogVisible=t}}},[n("el-upload",{staticClass:"editor-slide-upload",attrs:{action:"/v1/upload/image",multiple:!0,"file-list":e.fileList,"show-file-list":!0,"list-type":"picture-card","on-remove":e.handleRemove,"on-success":e.handleSuccess,"before-upload":e.beforeUpload,"http-request":e.myUpload}},[n("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")])],1),e._v(" "),n("el-button",{on:{click:function(t){e.dialogVisible=!1}}},[e._v("取 消")]),e._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:e.handleSubmit}},[e._v("确 定")])],1)],1)},i=[]},484:function(t,e,n){"use strict";e.a=["advlist anchor autolink autosave code codesample colorpicker colorpicker contextmenu directionality emoticons fullscreen hr image imagetools importcss insertdatetime link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker tabfocus table template textcolor textpattern visualblocks visualchars wordcount"]},485:function(t,e,n){"use strict";e.a=["bold italic underline strikethrough alignleft aligncenter alignright outdent indent  blockquote undo redo removeformat subscript superscript code codesample","hr bullist numlist link image charmap\t preview anchor pagebreak insertdatetime media table emoticons forecolor backcolor fullscreen"]},486:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tinymce-container editor-container",class:{fullscreen:t.fullscreen}},[n("textarea",{staticClass:"tinymce-textarea",attrs:{id:t.tinymceId}}),t._v(" "),n("div",{staticClass:"editor-custom-btn-container"},[n("editorImage",{staticClass:"editor-upload-btn",attrs:{color:"#1890ff"},on:{successCBK:t.imageSuccessCBK}})],1)])},i=[]},504:function(t,e,n){"use strict";e.d=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.get("/v1/page/list",t)},e.c=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.get("/v1/page/detail",t)},e.a=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/page/create",t)},e.e=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/page/update",t)},e.b=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/page/delete",t)};var a=n(30)},505:function(t,e,n){"use strict";var a=n(20),i=n.n(a),o=n(465),r=n(452),s=n(477),l=n(504),c=n(48);e.a={name:"PageForm",components:{Sticky:o.a,Upload:r.a,Tinymce:s.a},props:{isEdit:{type:Boolean,default:!1}},data:function(){return{loading:!1,status:"draft",banner:"",otherBanner:"",dataForm:{path:"",onlineAt:"",offlineAt:"",banner:"",zh:{title:"",navTitle:"",otherBanner:"",summary:"",content:"",metaTitle:"",keywords:"",description:""}},rules:{path:[{required:!0,message:"请输入路径",trigger:"blur"}],"zh.title":[{required:!0,message:"请输入标题",trigger:"blur"}]}}},computed:i()({},Object(c.b)(["setting"])),created:function(){var e=this;if(!0===this.isEdit){var t=this.$route.params.id;Object(l.c)({id:t}).then(function(t){0===t.code&&(e.dataForm=t.data,e.banner=e.setting.domain+e.dataForm.banner,e.otherBanner=e.setting.domain+e.dataForm.zh.otherBanner)}).catch(function(t){e.$router.push({path:"/404"})})}},methods:{updateBanner:function(t){this.dataForm.banner=t},updateOtherBanner:function(t){this.dataForm.zh.otherBanner=t},submitForm:function(){var e=this;this.$refs.dataForm.validate(function(t){if(!t)return!1;1==e.isEdit?e.handleUpdate():e.handleCreate()})},handleCreate:function(){var n=this,t=this.dataForm.zh;delete this.dataForm.zh,Object(l.a)(i()({},this.dataForm,t)).then(function(t){if(100==t.code){var e=t.data;n.showErrorMessage(e)}else n.$router.push("/content/page"),n.loading=!0,n.$notify({title:"成功",message:"发布文章成功",type:"success",duration:2e3}),n.status="published",n.loading=!1})},handleUpdate:function(){var n=this,a=this.dataForm.zh;delete this.dataForm.zh,Object(l.e)(i()({},this.dataForm,a)).then(function(t){if(100==t.code){var e=t.data;n.showErrorMessage(e)}else n.loading=!0,n.$notify({title:"成功",message:"更新文章成功",type:"success",duration:2e3}),n.status="published",n.loading=!1,n.dataForm.zh=a})},showErrorMessage:function(t){var e=this,n=[];t.map(function(t){n.push(e.$t(t))}),this.$message({message:n.join("，"),type:"error"})}}}},544:function(t,e,n){"use strict";var a=n(505),i=n(547),o=n(4);var r=function(t){n(545)},s=Object(o.a)(a.a,i.a,i.b,!1,r,"data-v-065a5a53",null);e.a=s.exports},545:function(t,e,n){var a=n(546);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("20f66954",a,!0,{})},546:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,'\n.container[data-v-065a5a53] {\n  position: relative;\n}\n.container .page-main-container[data-v-065a5a53] {\n    padding: 40px 45px 40px 50px;\n}\n.container .page-main-container .postInfo-container[data-v-065a5a53] {\n      position: relative;\n      margin-bottom: 10px;\n}\n.container .page-main-container .postInfo-container[data-v-065a5a53]:after {\n        content: "";\n        display: table;\n        clear: both;\n}\n.container .page-main-container .postInfo-container .postInfo-container-item[data-v-065a5a53] {\n        float: left;\n}\n.container .word-counter[data-v-065a5a53] {\n    width: 40px;\n    position: absolute;\n    right: -10px;\n    top: 0px;\n}\n',""])},547:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"container"},[n("el-form",{ref:"dataForm",staticClass:"form-container",attrs:{model:e.dataForm,rules:e.rules}},[n("sticky",{attrs:{"class-name":"sub-navbar "+e.status,zIndex:3}},[n("el-button",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{"margin-right":"10px"},attrs:{type:"success"},on:{click:e.submitForm}},[e.isEdit?n("span",[e._v("更新")]):n("span",[e._v("创建")])]),e._v(" "),n("router-link",{attrs:{to:"/content/page"}},[n("el-button",[e._v("返回")])],1)],1),e._v(" "),n("div",{staticClass:"page-main-container"},[n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{sm:16}},[n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"路径",prop:"path"}},[n("el-input",{model:{value:e.dataForm.path,callback:function(t){e.$set(e.dataForm,"path",t)},expression:"dataForm.path"}})],1),e._v(" "),n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"上线时间"}},[n("el-date-picker",{attrs:{type:"datetime",format:"yyyy-MM-dd HH:mm:ss",placeholder:"选择日期时间","value-format":"yyyy-MM-dd HH:mm:ss"},model:{value:e.dataForm.onlineAt,callback:function(t){e.$set(e.dataForm,"onlineAt",t)},expression:"dataForm.onlineAt"}})],1),e._v(" "),n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"下线时间"}},[n("el-date-picker",{attrs:{type:"datetime",format:"yyyy-MM-dd HH:mm:ss",placeholder:"选择日期时间","value-format":"yyyy-MM-dd HH:mm:ss"},model:{value:e.dataForm.offlineAt,callback:function(t){e.$set(e.dataForm,"offlineAt",t)},expression:"dataForm.offlineAt"}})],1),e._v(" "),n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"横幅"}},[n("Upload",{attrs:{value:e.dataForm.banner},on:{value:e.updateBanner},model:{value:e.banner,callback:function(t){e.banner=t},expression:"banner"}})],1),e._v(" "),n("el-tabs",{staticStyle:{"margin-top":"15px"},attrs:{type:"border-card"}},[n("el-tab-pane",{staticStyle:{"z-index":"-1"},attrs:{label:"中文"}},[n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"标题",prop:"zh.title"}},[n("el-input",{model:{value:e.dataForm.zh.title,callback:function(t){e.$set(e.dataForm.zh,"title",t)},expression:"dataForm.zh.title"}})],1),e._v(" "),n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"菜单标题",prop:"navTitle"}},[n("el-input",{model:{value:e.dataForm.zh.navTitle,callback:function(t){e.$set(e.dataForm.zh,"navTitle",t)},expression:"dataForm.zh.navTitle"}})],1),e._v(" "),n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"横幅",prop:"otherBanner"}},[n("Upload",{attrs:{value:e.dataForm.zh.otherBanner},on:{value:e.updateOtherBanner},model:{value:e.otherBanner,callback:function(t){e.otherBanner=t},expression:"otherBanner"}})],1),e._v(" "),n("el-form-item",{attrs:{"label-width":"80px",label:"摘要"}},[n("el-input",{attrs:{rows:2,type:"textarea"},model:{value:e.dataForm.zh.summary,callback:function(t){e.$set(e.dataForm.zh,"summary",t)},expression:"dataForm.zh.summary"}})],1),e._v(" "),n("el-form-item",{staticStyle:{"margin-bottom":"30px"},attrs:{prop:"content"}},[n("Tinymce",{ref:"editor",attrs:{height:400},model:{value:e.dataForm.zh.content,callback:function(t){e.$set(e.dataForm.zh,"content",t)},expression:"dataForm.zh.content"}})],1),e._v(" "),n("el-form-item",{attrs:{"label-width":"120px",label:"SEO标题"}},[n("el-input",{attrs:{rows:4,type:"textarea"},model:{value:e.dataForm.zh.metaTitle,callback:function(t){e.$set(e.dataForm.zh,"metaTitle",t)},expression:"dataForm.zh.metaTitle"}})],1),e._v(" "),n("el-form-item",{attrs:{"label-width":"120px",label:"SEO关键词"}},[n("el-input",{attrs:{rows:4,type:"textarea"},model:{value:e.dataForm.zh.keywords,callback:function(t){e.$set(e.dataForm.zh,"keywords",t)},expression:"dataForm.zh.keywords"}})],1),e._v(" "),n("el-form-item",{attrs:{"label-width":"120px",label:"SEO页面简介"}},[n("el-input",{attrs:{rows:4,type:"textarea"},model:{value:e.dataForm.zh.description,callback:function(t){e.$set(e.dataForm.zh,"description",t)},expression:"dataForm.zh.description"}})],1)],1)],1)],1),e._v(" "),n("el-col",{attrs:{sm:8}},[n("el-card",{staticClass:"box-card"},[n("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},[n("span",[e._v("修改历史")])]),e._v(" "),n("div")])],1)],1)],1)],1)],1)},i=[]},584:function(t,e,n){"use strict";var a=n(544);e.a={name:"EditPage",components:{PageForm:a.a},data:function(){return{}}}},692:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var t=this.$createElement;return(this._self._c||t)("page-form",{attrs:{"is-edit":!0}})},i=[]}});