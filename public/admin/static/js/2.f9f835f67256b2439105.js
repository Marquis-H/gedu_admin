webpackJsonp([2],{1038:function(t,e,n){var i=n(1039);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,n(24).default)("47a63a3c",i,!0,{})},1039:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n",""])},1040:function(t,e,n){"use strict";n.d(e,"a",function(){return i}),n.d(e,"b",function(){return a});var i=function(){var t=this.$createElement;return(this._self._c||t)("page-form",{attrs:{"is-edit":!0}})},a=[]},426:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=n(676),a=n(1040),o=n(4);var s=function(t){n(1038)},r=Object(o.a)(i.a,a.a,a.b,!1,s,null,null);e.default=r.exports},441:function(t,e,n){"use strict";var i=n(85),a=n.n(i);e.a={name:"singleImageUpload2",props:{value:String},computed:{imageUrl:function(){return this.value}},data:function(){return{tempUrl:"",action:"https://gedu.qidorg.com/v1/upload/image"}},methods:{rmImage:function(){this.emitInput(""),this.emitValue("")},emitInput:function(t){this.$emit("input",t)},emitValue:function(t){this.$emit("value",t)},handleImageScucess:function(t,e,n){this.tempUrl=e.url,this.emitInput(this.tempUrl),this.emitValue(t.file)},myUpload:function(e){var t=new XMLHttpRequest,n=e.file;t.upload&&(t.upload.onprogress=function(t){0<t.total&&(t.percent=t.loaded/t.total*100),e.onProgress(t)});var i=new FormData;e.data&&a()(e.data).map(function(t){i.append(t,e.data[t])}),i.append(e.filename,e.file),t.onerror=function(t){e.onError(t)},t.onload=function(){if(t.status<200||300<=t.status)return e.onError(function(t,e,n){var i;i=n.response?n.status+(n.response.error||n.response):n.responseText?n.status+n.responseText:"fail to post "+t+n.status;var a=new Error(i);return a.status=n.status,a.method="post",a.url=t,a}(action,0,t));e.onSuccess(function(t){var e=t.responseText||t.response;if(!e)return e;try{var n=JSON.parse(e);return n.data}catch(t){return e}}(t))},t.open("post",e.action,!0),e.withCredentials&&"withCredentials"in t&&(t.withCredentials=!0),t.setRequestHeader("X-File-Name",encodeURIComponent(n.name)),t.setRequestHeader("X-File-Size",n.size),t.send(n)}}}},452:function(t,e,n){"use strict";var i=n(441),a=n(455),o=n(4);var s=function(t){n(453)},r=Object(o.a)(i.a,a.a,a.b,!1,s,"data-v-1bd19ec2",null);e.a=r.exports},453:function(t,e,n){var i=n(454);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,n(24).default)("883aa9fc",i,!0,{})},454:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.upload-container[data-v-1bd19ec2] {\n  width: 50%;\n  height: 100%;\n  position: relative;\n}\n.upload-container .image-uploader[data-v-1bd19ec2] {\n    height: 100%;\n}\n.upload-container .image-preview[data-v-1bd19ec2] {\n    width: 100%;\n    height: 100%;\n    position: absolute;\n    left: 0px;\n    top: 0px;\n    border: 1px dashed #d9d9d9;\n}\n.upload-container .image-preview .image-preview-wrapper[data-v-1bd19ec2] {\n      position: relative;\n      width: 100%;\n      height: 100%;\n}\n.upload-container .image-preview .image-preview-wrapper img[data-v-1bd19ec2] {\n        width: 100%;\n        height: 100%;\n}\n.upload-container .image-preview .image-preview-action[data-v-1bd19ec2] {\n      position: absolute;\n      width: 100%;\n      height: 100%;\n      left: 0;\n      top: 0;\n      cursor: default;\n      text-align: center;\n      color: #fff;\n      opacity: 0;\n      font-size: 20px;\n      background-color: rgba(0, 0, 0, 0.5);\n      transition: opacity 0.3s;\n      cursor: pointer;\n      text-align: center;\n      line-height: 200px;\n}\n.upload-container .image-preview .image-preview-action .el-icon-delete[data-v-1bd19ec2] {\n        font-size: 36px;\n}\n.upload-container .image-preview:hover .image-preview-action[data-v-1bd19ec2] {\n      opacity: 1;\n}\n",""])},455:function(t,e,n){"use strict";n.d(e,"a",function(){return i}),n.d(e,"b",function(){return a});var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"singleImageUpload2 upload-container"},[n("el-upload",{staticClass:"image-uploader",attrs:{drag:"",multiple:!1,"show-file-list":!1,action:t.action,"on-success":t.handleImageScucess,"http-request":t.myUpload}},[n("i",{staticClass:"el-icon-upload"}),t._v(" "),n("div",{staticClass:"el-upload__text"},[t._v("Drag或"),n("em",[t._v("点击上传")])])]),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:0<t.imageUrl.length,expression:"imageUrl.length>0"}],staticClass:"image-preview"},[n("div",{directives:[{name:"show",rawName:"v-show",value:1<t.imageUrl.length,expression:"imageUrl.length>1"}],staticClass:"image-preview-wrapper"},[n("img",{attrs:{src:t.imageUrl}}),t._v(" "),n("div",{staticClass:"image-preview-action"},[n("i",{staticClass:"el-icon-delete",on:{click:t.rmImage}})])])])],1)},a=[]},456:function(t,e,n){"use strict";e.a={name:"Sticky",props:{stickyTop:{type:Number,default:0},zIndex:{type:Number,default:1},className:{type:String}},data:function(){return{active:!1,position:"",width:void 0,height:void 0,isSticky:!1}},mounted:function(){this.height=this.$el.getBoundingClientRect().height,window.addEventListener("scroll",this.handleScroll),window.addEventListener("resize",this.handleReize)},activated:function(){this.handleScroll()},destroyed:function(){window.removeEventListener("scroll",this.handleScroll),window.removeEventListener("resize",this.handleReize)},methods:{sticky:function(){this.active||(this.position="fixed",this.active=!0,this.width=this.width+"px",this.isSticky=!0)},reset:function(){this.active&&(this.position="",this.width="auto",this.active=!1,this.isSticky=!1)},handleScroll:function(){this.width=this.$el.getBoundingClientRect().width,this.$el.getBoundingClientRect().top<this.stickyTop?this.sticky():this.reset()},handleReize:function(){this.isSticky&&(this.width=this.$el.getBoundingClientRect().width+"px")}}}},460:function(t,e,n){"use strict";var i=n(20),a=n.n(i),o=n(480),s=n(484),r=n(485),c=n(48);e.a={name:"tinymce",components:{editorImage:o.a},props:{id:{type:String},value:{type:String,default:""},toolbar:{type:Array,required:!1,default:function(){return[]}},menubar:{default:"file edit insert view format table"},height:{type:Number,required:!1,default:360}},data:function(){return{hasChange:!1,hasInit:!1,tinymceId:this.id||"vue-tinymce-"+ +new Date,fullscreen:!1}},computed:a()({},Object(c.b)(["setting"])),watch:{value:function(t){var e=this;!this.hasChange&&this.hasInit&&this.$nextTick(function(){return window.tinymce.get(e.tinymceId).setContent(t||"")})}},mounted:function(){this.initTinymce()},activated:function(){this.initTinymce()},deactivated:function(){this.destroyTinymce()},methods:{initTinymce:function(){var e=this,n=this;window.tinymce.init({language:"zh_CN",selector:"#"+this.tinymceId,height:this.height,body_class:"panel-body ",object_resizing:!1,toolbar:0<this.toolbar.length?this.toolbar:r.a,menubar:this.menubar,plugins:s.a,end_container_on_empty_block:!0,powerpaste_word_import:"clean",code_dialog_height:450,code_dialog_width:1e3,advlist_bullet_styles:"square",advlist_number_styles:"default",imagetools_cors_hosts:["www.tinymce.com","codepen.io"],default_link_target:"_blank",link_title:!1,nonbreaking_force_tab:!0,init_instance_callback:function(t){n.value&&t.setContent(n.value),n.hasInit=!0,t.on("NodeChange Change KeyUp SetContent",function(){e.hasChange=!0,e.$emit("input",t.getContent())})},setup:function(t){t.on("FullscreenStateChanged",function(t){n.fullscreen=t.state})}})},destroyTinymce:function(){window.tinymce.get(this.tinymceId)&&window.tinymce.get(this.tinymceId).destroy()},setContent:function(t){window.tinymce.get(this.tinymceId).setContent(t)},getContent:function(){window.tinymce.get(this.tinymceId).getContent()},imageSuccessCBK:function(t){var n=this,i=this;t.forEach(function(t){var e=n.setting.domain+t.url;window.tinymce.get(i.tinymceId).insertContent('<img class="wscnph" src="'+e+'" >')})}},destroyed:function(){this.destroyTinymce()}}},461:function(t,e,n){"use strict";var i=n(50),r=n.n(i),a=n(85),s=n.n(a);e.a={name:"editorSlideUpload",props:{color:{type:String,default:"#1890ff"}},data:function(){return{dialogVisible:!1,listObj:{},fileList:[]}},methods:{checkAllSuccess:function(){var e=this;return s()(this.listObj).every(function(t){return e.listObj[t].hasSuccess})},handleSubmit:function(){var e=this,t=s()(this.listObj).map(function(t){return e.listObj[t]});this.checkAllSuccess()?(this.$emit("successCBK",t),this.listObj={},this.fileList=[],this.dialogVisible=!1):this.$message("请等待所有图片上传成功 或 出现了网络问题，请刷新页面重新上传！")},handleSuccess:function(t,e){for(var n=e.uid,i=s()(this.listObj),a=0,o=i.length;a<o;a++)if(this.listObj[i[a]].uid===n)return this.listObj[i[a]].url=t.file,void(this.listObj[i[a]].hasSuccess=!0)},handleRemove:function(t){for(var e=t.uid,n=s()(this.listObj),i=0,a=n.length;i<a;i++)if(this.listObj[n[i]].uid===e)return void delete this.listObj[n[i]]},beforeUpload:function(i){var a=this,o=window.URL||window.webkitURL,s=i.uid;return this.listObj[s]={},new r.a(function(t,e){var n=new Image;n.src=o.createObjectURL(i),n.onload=function(){a.listObj[s]={hasSuccess:!1,uid:i.uid,width:this.width,height:this.height}},t(!0)})},myUpload:function(e){var t=new XMLHttpRequest,n=e.file;t.upload&&(t.upload.onprogress=function(t){0<t.total&&(t.percent=t.loaded/t.total*100),e.onProgress(t)});var i=new FormData;e.data&&s()(e.data).map(function(t){i.append(t,e.data[t])}),i.append(e.filename,e.file),t.onerror=function(t){e.onError(t)},t.onload=function(){if(t.status<200||300<=t.status)return e.onError(function(t,e,n){var i;i=n.response?n.status+(n.response.error||n.response):n.responseText?n.status+n.responseText:"fail to post "+t+n.status;var a=new Error(i);return a.status=n.status,a.method="post",a.url=t,a}(action,0,t));e.onSuccess(function(t){var e=t.responseText||t.response;if(!e)return e;try{var n=JSON.parse(e);return n.data}catch(t){return e}}(t))},t.open("post",e.action,!0),e.withCredentials&&"withCredentials"in t&&(t.withCredentials=!0),t.setRequestHeader("X-File-Name",encodeURIComponent(n.name)),t.setRequestHeader("X-File-Size",n.size),t.send(n)}}}},465:function(t,e,n){"use strict";var i=n(456),a=n(466),o=n(4),s=Object(o.a)(i.a,a.a,a.b,!1,null,null,null);e.a=s.exports},466:function(t,e,n){"use strict";n.d(e,"a",function(){return i}),n.d(e,"b",function(){return a});var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{style:{height:t.height+"px",zIndex:t.zIndex}},[n("div",{class:t.className,style:{top:t.stickyTop+"px",zIndex:t.zIndex,position:t.position,width:t.width,height:t.height+"px"}},[t._t("default",[n("div",[t._v("sticky")])])],2)])},a=[]},473:function(t,e,n){"use strict";e.c=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/campus/list",t)},e.a=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/campus/create",t)},e.e=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/campus/update",t)},e.b=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/campus/delete",t)},e.d=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/campus/items",t)};var i=n(30)},477:function(t,e,n){"use strict";var i=n(460),a=n(486),o=n(4);var s=function(t){n(478)},r=Object(o.a)(i.a,a.a,a.b,!1,s,"data-v-1428fa49",null);e.a=r.exports},478:function(t,e,n){var i=n(479);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,n(24).default)("84ac9d2e",i,!0,{})},479:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.tinymce-container[data-v-1428fa49] {\n  position: relative;\n}\n.tinymce-container[data-v-1428fa49] .mce-fullscreen {\n  z-index: 10000;\n}\n.tinymce-textarea[data-v-1428fa49] {\n  visibility: hidden;\n  z-index: -1;\n}\n.editor-custom-btn-container[data-v-1428fa49] {\n  position: absolute;\n  right: 4px;\n  top: 4px;\n  line-height: 0;\n  /*z-index: 2005;*/\n}\n.fullscreen .editor-custom-btn-container[data-v-1428fa49] {\n  z-index: 10000;\n  position: fixed;\n}\n.editor-upload-btn[data-v-1428fa49] {\n  display: inline-block;\n  line-height: 0;\n}\n",""])},480:function(t,e,n){"use strict";var i=n(461),a=n(483),o=n(4);var s=function(t){n(481)},r=Object(o.a)(i.a,a.a,a.b,!1,s,"data-v-f6ff36a2",null);e.a=r.exports},481:function(t,e,n){var i=n(482);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,n(24).default)("3cb134b2",i,!0,{})},482:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.editor-slide-upload[data-v-f6ff36a2] {\n  margin-bottom: 20px;\n}\n.editor-slide-upload[data-v-f6ff36a2] .el-upload--picture-card {\n    width: 100%;\n}\n",""])},483:function(t,e,n){"use strict";n.d(e,"a",function(){return i}),n.d(e,"b",function(){return a});var i=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"upload-container"},[n("el-button",{style:{background:e.color,borderColor:e.color},attrs:{icon:"el-icon-upload",size:"mini",type:"primary"},on:{click:function(t){e.dialogVisible=!0}}},[e._v("上传图片\n  ")]),e._v(" "),n("el-dialog",{attrs:{visible:e.dialogVisible},on:{"update:visible":function(t){e.dialogVisible=t}}},[n("el-upload",{staticClass:"editor-slide-upload",attrs:{action:"/v1/upload/image",multiple:!0,"file-list":e.fileList,"show-file-list":!0,"list-type":"picture-card","on-remove":e.handleRemove,"on-success":e.handleSuccess,"before-upload":e.beforeUpload,"http-request":e.myUpload}},[n("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")])],1),e._v(" "),n("el-button",{on:{click:function(t){e.dialogVisible=!1}}},[e._v("取 消")]),e._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:e.handleSubmit}},[e._v("确 定")])],1)],1)},a=[]},484:function(t,e,n){"use strict";e.a=["advlist anchor autolink autosave code codesample colorpicker colorpicker contextmenu directionality emoticons fullscreen hr image imagetools importcss insertdatetime link lists media nonbreaking noneditable pagebreak paste preview print save searchreplace spellchecker tabfocus table template textcolor textpattern visualblocks visualchars wordcount"]},485:function(t,e,n){"use strict";e.a=["bold italic underline strikethrough alignleft aligncenter alignright outdent indent  blockquote undo redo removeformat subscript superscript code codesample","hr bullist numlist link image charmap\t preview anchor pagebreak insertdatetime media table emoticons forecolor backcolor fullscreen"]},486:function(t,e,n){"use strict";n.d(e,"a",function(){return i}),n.d(e,"b",function(){return a});var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tinymce-container editor-container",class:{fullscreen:t.fullscreen}},[n("textarea",{staticClass:"tinymce-textarea",attrs:{id:t.tinymceId}}),t._v(" "),n("div",{staticClass:"editor-custom-btn-container"},[n("editorImage",{staticClass:"editor-upload-btn",attrs:{color:"#1890ff"},on:{successCBK:t.imageSuccessCBK}})],1)])},a=[]},497:function(t,e,n){"use strict";e.e=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/content_cat/list",t)},e.b=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/content_cat/create",t)},e.j=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/content_cat/update",t)},e.d=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/content_cat/delete",t)},e.h=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/content_cat/items",t)},e.g=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/content/list",t)},e.f=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/content/detail",t)},e.a=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/content/create",t)},e.i=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/content/update",t)},e.c=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/content/delete",t)};var i=n(30)},522:function(t,e,n){"use strict";var i=n(20),a=n.n(i),o=n(465),s=n(452),r=n(477),c=n(497),l=n(473),u=n(48);e.a={name:"PageForm",components:{Sticky:o.a,Upload:s.a,Tinymce:r.a},props:{isEdit:{type:Boolean,default:!1}},data:function(){return{loading:!1,status:"draft",photo:"",contentCat:[],campus:[],dataForm:{title:"",photo:"",summary:"",content:"",extra:"",catId:"",campusId:""},rules:{title:[{required:!0,message:"请输入标题",trigger:"blur"}],content:[{required:!0,message:"请输入内容",trigger:"blur"}],catId:[{required:!0,message:"请选择分类",trigger:"blur"}]}}},computed:a()({},Object(u.b)(["setting"])),created:function(){var e=this;if(!0===this.isEdit){var t=this.$route.params.id;Object(c.f)({id:t}).then(function(t){0===t.code&&(e.dataForm=t.data,e.photo=e.setting.domain+e.dataForm.photo)}).catch(function(t){e.$router.push({path:"/404"})})}this.getContentCat(),this.getCampus()},methods:{getContentCat:function(){var e=this;Object(c.h)().then(function(t){e.contentCat=t.data})},getCampus:function(){var e=this;Object(l.d)().then(function(t){e.campus=t.data})},updatePhoto:function(t){this.dataForm.photo=t},submitForm:function(){var e=this;this.$refs.dataForm.validate(function(t){if(!t)return!1;1==e.isEdit?e.handleUpdate():e.handleCreate()})},handleCreate:function(){var n=this;Object(c.a)(this.dataForm).then(function(t){if(100==t.code){var e=t.data;n.showErrorMessage(e)}else n.$router.push("/app_content/index"),n.loading=!0,n.$notify({title:"成功",message:"发布内容成功",type:"success",duration:2e3}),n.status="published",n.loading=!1})},handleUpdate:function(){var n=this;Object(c.i)(this.dataForm).then(function(t){if(100==t.code){var e=t.data;n.showErrorMessage(e)}else n.loading=!0,n.$notify({title:"成功",message:"更新内容成功",type:"success",duration:2e3}),n.status="published",n.loading=!1})},showErrorMessage:function(t){var e=this,n=[];t.map(function(t){n.push(e.$t(t))}),this.$message({message:n.join("，"),type:"error"})}}}},573:function(t,e,n){"use strict";var i=n(522),a=n(576),o=n(4);var s=function(t){n(574)},r=Object(o.a)(i.a,a.a,a.b,!1,s,"data-v-554f6bd0",null);e.a=r.exports},574:function(t,e,n){var i=n(575);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);(0,n(24).default)("59099a28",i,!0,{})},575:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,'\n.container[data-v-554f6bd0] {\n  position: relative;\n}\n.container .page-main-container[data-v-554f6bd0] {\n    padding: 40px 45px 40px 50px;\n}\n.container .page-main-container .postInfo-container[data-v-554f6bd0] {\n      position: relative;\n      margin-bottom: 10px;\n}\n.container .page-main-container .postInfo-container[data-v-554f6bd0]:after {\n        content: "";\n        display: table;\n        clear: both;\n}\n.container .page-main-container .postInfo-container .postInfo-container-item[data-v-554f6bd0] {\n        float: left;\n}\n.container .word-counter[data-v-554f6bd0] {\n    width: 40px;\n    position: absolute;\n    right: -10px;\n    top: 0px;\n}\n',""])},576:function(t,e,n){"use strict";n.d(e,"a",function(){return i}),n.d(e,"b",function(){return a});var i=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"container"},[n("el-form",{ref:"dataForm",staticClass:"form-container",attrs:{model:e.dataForm,rules:e.rules}},[n("sticky",{attrs:{"class-name":"sub-navbar "+e.status,zIndex:3}},[n("el-button",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{"margin-right":"10px"},attrs:{type:"success"},on:{click:e.submitForm}},[e.isEdit?n("span",[e._v("更新")]):n("span",[e._v("创建")])]),e._v(" "),n("router-link",{attrs:{to:"/app_content/index"}},[n("el-button",[e._v("返回")])],1)],1),e._v(" "),n("div",{staticClass:"page-main-container"},[n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{sm:16}},[n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"标题",prop:"title"}},[n("el-input",{model:{value:e.dataForm.title,callback:function(t){e.$set(e.dataForm,"title",t)},expression:"dataForm.title"}})],1),e._v(" "),n("el-form-item",{staticClass:"postInfo-container-item",attrs:{"label-width":"80px",label:"照片"}},[n("Upload",{attrs:{value:e.dataForm.photo},on:{value:e.updatePhoto},model:{value:e.photo,callback:function(t){e.photo=t},expression:"photo"}})],1),e._v(" "),n("el-form-item",{attrs:{"label-width":"80px",label:"摘要"}},[n("el-input",{attrs:{rows:2,type:"textarea"},model:{value:e.dataForm.summary,callback:function(t){e.$set(e.dataForm,"summary",t)},expression:"dataForm.summary"}})],1),e._v(" "),n("el-form-item",{staticStyle:{"margin-bottom":"30px"},attrs:{prop:"content"}},[n("Tinymce",{ref:"editor",attrs:{height:400},model:{value:e.dataForm.content,callback:function(t){e.$set(e.dataForm,"content",t)},expression:"dataForm.content"}})],1),e._v(" "),n("el-form-item",{attrs:{"label-width":"80px",label:"额外信息"}},[n("el-input",{attrs:{rows:2,type:"textarea"},model:{value:e.dataForm.extra,callback:function(t){e.$set(e.dataForm,"extra",t)},expression:"dataForm.extra"}})],1),e._v(" "),n("el-form-item",{attrs:{label:e.$t("table.contentCat"),prop:"catId"}},[n("el-select",{attrs:{placeholder:"请选择"},model:{value:e.dataForm.catId,callback:function(t){e.$set(e.dataForm,"catId",t)},expression:"dataForm.catId"}},e._l(e.contentCat,function(t,e){return n("el-option",{key:e,attrs:{label:t.label,value:t.value}})}))],1),e._v(" "),n("el-form-item",{attrs:{label:e.$t("table.campus"),prop:"campusId"}},[n("el-select",{attrs:{placeholder:"请选择"},model:{value:e.dataForm.campusId,callback:function(t){e.$set(e.dataForm,"campusId",t)},expression:"dataForm.campusId"}},e._l(e.campus,function(t,e){return n("el-option",{key:e,attrs:{label:t.label,value:t.value}})}))],1)],1),e._v(" "),n("el-col",{attrs:{sm:8}},[n("el-card",{staticClass:"box-card"},[n("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},[n("span",[e._v("修改历史")])]),e._v(" "),n("div")])],1)],1)],1)],1)],1)},a=[]},676:function(t,e,n){"use strict";var i=n(573);e.a={name:"EditContent",components:{PageForm:i.a},data:function(){return{}}}}});