webpackJsonp([5],{1041:function(t,e,n){var a=n(1042);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("14029f5f",a,!0,{})},1042:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n",""])},1043:function(t,e,n){"use strict";e.c=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.get("/v1/prize/list",t)},e.a=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/prize/create",t)},e.d=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/prize/update",t)},e.b=function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/prize/delete",t)};var a=n(30)},1044:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var n=this,t=n.$createElement,a=n._self._c||t;return a("div",{staticClass:"app-container"},[a("div",{staticClass:"filter-container"},[a("el-button",{staticClass:"filter-item",staticStyle:{"margin-left":"10px"},attrs:{type:"primary",icon:"el-icon-edit"},on:{click:n.handleCreate}},[n._v(n._s(n.$t("table.add")))])],1),n._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:n.listLoading,expression:"listLoading"}],key:n.tableKey,staticStyle:{width:"100%"},attrs:{data:n.list,border:"",fit:"","highlight-current-row":""}},[a("el-table-column",{attrs:{label:n.$t("table.photo"),align:"center",width:"120"},scopedSlots:n._u([{key:"default",fn:function(t){return[t.row.photo?a("img",{attrs:{width:"100%",src:n.setting.domain+t.row.photo}}):a("span",[n._v("-")])]}}])}),n._v(" "),a("el-table-column",{attrs:{label:n.$t("table.title"),align:"center","min-width":"150"},scopedSlots:n._u([{key:"default",fn:function(t){return[a("span",[n._v(n._s(t.row.title))])]}}])}),n._v(" "),a("el-table-column",{attrs:{label:n.$t("table.integral"),align:"center","min-width":"150"},scopedSlots:n._u([{key:"default",fn:function(t){return[a("span",[n._v(n._s(t.row.integral))])]}}])}),n._v(" "),a("el-table-column",{attrs:{label:n.$t("table.updatedAt"),align:"center","min-width":"150"},scopedSlots:n._u([{key:"default",fn:function(t){return[a("span",[n._v(n._s(t.row.updatedAt))])]}}])}),n._v(" "),a("el-table-column",{attrs:{label:n.$t("table.actions"),align:"center",width:"230","class-name":"small-padding fixed-width"},scopedSlots:n._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(t){n.handleUpdate(e.row)}}},[n._v(n._s(n.$t("table.edit")))]),n._v(" "),a("el-popover",{attrs:{placement:"top",width:"160"},model:{value:e.row.del,callback:function(t){n.$set(e.row,"del",t)},expression:"scope.row.del"}},[a("p",[n._v(n._s(n.$t("table.del_tips")))]),n._v(" "),a("div",{staticStyle:{"text-align":"right",margin:"0"}},[a("el-button",{attrs:{size:"mini",type:"text"},on:{click:function(t){e.row.del=!1}}},[n._v(n._s(n.$t("table.cancel")))]),n._v(" "),a("el-button",{attrs:{size:"mini",type:"primary"},on:{click:function(t){n.handleDelete(e.row)}}},[n._v(n._s(n.$t("table.confirm")))])],1),n._v(" "),a("el-button",{attrs:{slot:"reference",size:"mini",type:"danger"},on:{click:function(t){e.row.del=!0}},slot:"reference"},[n._v(n._s(n.$t("table.delete")))])],1)]}}])})],1),n._v(" "),a("div",{staticClass:"pagination-container"},[a("el-pagination",{directives:[{name:"show",rawName:"v-show",value:0<n.total,expression:"total>0"}],attrs:{"current-page":n.listQuery.page,"page-size":n.listQuery.limit,total:n.total,background:"",layout:"total, prev, pager, next, jumper"},on:{"size-change":n.handleSizeChange,"current-change":n.handleCurrentChange}})],1),n._v(" "),a("el-dialog",{attrs:{title:n.textMap[n.dialogStatus],visible:n.dialogFormVisible,width:"60%"},on:{"update:visible":function(t){n.dialogFormVisible=t}}},[a("el-form",{ref:"dataForm",staticStyle:{width:"80%","margin-left":"50px"},attrs:{rules:n.rules,model:n.temp,"label-position":"left","label-width":"80px"}},[a("el-form-item",{attrs:{label:n.$t("table.photo"),prop:"photo"}},[a("Upload",{attrs:{value:n.temp.photo},on:{value:n.updateValue},model:{value:n.image,callback:function(t){n.image=t},expression:"image"}})],1),n._v(" "),a("el-form-item",{attrs:{label:n.$t("table.title"),prop:"title"}},[a("el-input",{model:{value:n.temp.title,callback:function(t){n.$set(n.temp,"title",t)},expression:"temp.title"}})],1),n._v(" "),a("el-form-item",{attrs:{label:n.$t("table.integral"),prop:"integral"}},[a("el-input",{attrs:{type:"number"},model:{value:n.temp.integral,callback:function(t){n.$set(n.temp,"integral",t)},expression:"temp.integral"}})],1)],1),n._v(" "),a("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(t){n.dialogFormVisible=!1}}},[n._v(n._s(n.$t("table.cancel")))]),n._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:function(t){"create"===n.dialogStatus?n.createData():n.updateData()}}},[n._v(n._s(n.$t("table.confirm")))])],1)],1)],1)},i=[]},427:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n(677),i=n(1044),s=n(4);var o=function(t){n(1041)},r=Object(s.a)(a.a,i.a,i.b,!1,o,null,null);e.default=r.exports},441:function(t,e,n){"use strict";var a=n(85),i=n.n(a);e.a={name:"singleImageUpload2",props:{value:String},computed:{imageUrl:function(){return this.value}},data:function(){return{tempUrl:""}},methods:{rmImage:function(){this.emitInput(""),this.emitValue("")},emitInput:function(t){this.$emit("input",t)},emitValue:function(t){this.$emit("value",t)},handleImageScucess:function(t,e,n){this.tempUrl=e.url,this.emitInput(this.tempUrl),this.emitValue(t.file)},myUpload:function(e){var t=new XMLHttpRequest,n=e.file;t.upload&&(t.upload.onprogress=function(t){0<t.total&&(t.percent=t.loaded/t.total*100),e.onProgress(t)});var a=new FormData;e.data&&i()(e.data).map(function(t){a.append(t,e.data[t])}),a.append(e.filename,e.file),t.onerror=function(t){e.onError(t)},t.onload=function(){if(t.status<200||300<=t.status)return e.onError(function(t,e,n){var a;a=n.response?n.status+(n.response.error||n.response):n.responseText?n.status+n.responseText:"fail to post "+t+n.status;var i=new Error(a);return i.status=n.status,i.method="post",i.url=t,i}(action,0,t));e.onSuccess(function(t){var e=t.responseText||t.response;if(!e)return e;try{var n=JSON.parse(e);return n.data}catch(t){return e}}(t))},t.open("post",e.action,!0),e.withCredentials&&"withCredentials"in t&&(t.withCredentials=!0),t.setRequestHeader("X-File-Name",encodeURIComponent(n.name)),t.setRequestHeader("X-File-Size",n.size),t.send(n)}}}},443:function(t,e,n){"use strict";var a=n(444),i=function(t){Vue.directive("waves",a.a)};window.Vue&&(window.waves=a.a,Vue.use(i)),a.a.install=i,e.a=a.a},444:function(t,e,n){"use strict";var a=n(84),l=n.n(a),i=n(445);n.n(i);e.a={bind:function(o,r){o.addEventListener("click",function(t){var e=l()({},r.value),n=l()({ele:o,type:"hit",color:"rgba(0, 0, 0, 0.15)"},e),a=n.ele;if(a){a.style.position="relative",a.style.overflow="hidden";var i=a.getBoundingClientRect(),s=a.querySelector(".waves-ripple");switch(s?s.className="waves-ripple":((s=document.createElement("span")).className="waves-ripple",s.style.height=s.style.width=Math.max(i.width,i.height)+"px",a.appendChild(s)),n.type){case"center":s.style.top=i.height/2-s.offsetHeight/2+"px",s.style.left=i.width/2-s.offsetWidth/2+"px";break;default:s.style.top=(t.pageY-i.top-s.offsetHeight/2-document.documentElement.scrollTop||document.body.scrollTop)+"px",s.style.left=(t.pageX-i.left-s.offsetWidth/2-document.documentElement.scrollLeft||document.body.scrollLeft)+"px"}return s.style.backgroundColor=n.color,!(s.className="waves-ripple z-active")}},!1)}}},445:function(t,e,n){var a=n(446);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("0b24217a",a,!0,{})},446:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,".waves-ripple {\n    position: absolute;\n    border-radius: 100%;\n    background-color: rgba(0, 0, 0, 0.15);\n    background-clip: padding-box;\n    pointer-events: none;\n    -webkit-user-select: none;\n    -moz-user-select: none;\n    -ms-user-select: none;\n    user-select: none;\n    -webkit-transform: scale(0);\n    -ms-transform: scale(0);\n    transform: scale(0);\n    opacity: 1;\n}\n\n.waves-ripple.z-active {\n    opacity: 0;\n    -webkit-transform: scale(2);\n    -ms-transform: scale(2);\n    transform: scale(2);\n    -webkit-transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out, -webkit-transform 0.6s ease-out;\n}",""])},452:function(t,e,n){"use strict";var a=n(441),i=n(455),s=n(4);var o=function(t){n(453)},r=Object(s.a)(a.a,i.a,i.b,!1,o,"data-v-bbbde68e",null);e.a=r.exports},453:function(t,e,n){var a=n(454);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);(0,n(24).default)("866e6b4a",a,!0,{})},454:function(t,e,n){(t.exports=n(19)(!1)).push([t.i,"\n.upload-container[data-v-bbbde68e] {\n  width: 50%;\n  height: 100%;\n  position: relative;\n}\n.upload-container .image-uploader[data-v-bbbde68e] {\n    height: 100%;\n}\n.upload-container .image-preview[data-v-bbbde68e] {\n    width: 100%;\n    height: 100%;\n    position: absolute;\n    left: 0px;\n    top: 0px;\n    border: 1px dashed #d9d9d9;\n}\n.upload-container .image-preview .image-preview-wrapper[data-v-bbbde68e] {\n      position: relative;\n      width: 100%;\n      height: 100%;\n}\n.upload-container .image-preview .image-preview-wrapper img[data-v-bbbde68e] {\n        width: 100%;\n        height: 100%;\n}\n.upload-container .image-preview .image-preview-action[data-v-bbbde68e] {\n      position: absolute;\n      width: 100%;\n      height: 100%;\n      left: 0;\n      top: 0;\n      cursor: default;\n      text-align: center;\n      color: #fff;\n      opacity: 0;\n      font-size: 20px;\n      background-color: rgba(0, 0, 0, 0.5);\n      transition: opacity 0.3s;\n      cursor: pointer;\n      text-align: center;\n      line-height: 200px;\n}\n.upload-container .image-preview .image-preview-action .el-icon-delete[data-v-bbbde68e] {\n        font-size: 36px;\n}\n.upload-container .image-preview:hover .image-preview-action[data-v-bbbde68e] {\n      opacity: 1;\n}\n",""])},455:function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"singleImageUpload2 upload-container"},[n("el-upload",{staticClass:"image-uploader",attrs:{drag:"",multiple:!1,"show-file-list":!1,action:"/v1/upload/image","on-success":t.handleImageScucess,"http-request":t.myUpload}},[n("i",{staticClass:"el-icon-upload"}),t._v(" "),n("div",{staticClass:"el-upload__text"},[t._v("Drag或"),n("em",[t._v("点击上传")])])]),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:0<t.imageUrl.length,expression:"imageUrl.length>0"}],staticClass:"image-preview"},[n("div",{directives:[{name:"show",rawName:"v-show",value:1<t.imageUrl.length,expression:"imageUrl.length>1"}],staticClass:"image-preview-wrapper"},[n("img",{attrs:{src:t.imageUrl}}),t._v(" "),n("div",{staticClass:"image-preview-action"},[n("i",{staticClass:"el-icon-delete",on:{click:t.rmImage}})])])])],1)},i=[]},677:function(t,e,n){"use strict";var a=n(49),u=n.n(a),i=n(84),s=n.n(i),o=n(20),r=n.n(o),l=n(443),c=n(452),d=n(1043),p=n(48);e.a={name:"Prize",directives:{waves:l.a},components:{Upload:c.a},data:function(){return{tableKey:0,list:null,total:0,listLoading:!1,listQuery:{page:1,limit:20,sortOrder:"ascend",filters:{}},sortOptions:[{label:"ID Ascending",key:"ascend"},{label:"ID Descending",key:"descend"}],image:"",temp:{photo:"",title:"",integral:0},dialogFormVisible:!1,dialogStatus:"",textMap:{update:this.$t("table.edit"),create:this.$t("table.add")},rules:{title:[{required:!0,message:this.$t("table.required"),trigger:"change"}]}}},created:function(){this.getList()},computed:r()({},Object(p.b)(["setting"])),methods:{getList:function(){var e=this;this.listLoading=!0,Object(d.c)(this.listQuery).then(function(t){e.list=t.data.items,e.total=t.data.pagination.total,e.listLoading=!1})},updateValue:function(t){this.temp.photo=t},resetTemp:function(){this.temp={photo:"",title:"",integral:0}},handleCreate:function(){var t=this;this.resetTemp(),this.dialogStatus="create",this.dialogFormVisible=!0,this.$nextTick(function(){t.$refs.dataForm.clearValidate()})},createData:function(){var n=this;this.$refs.dataForm.validate(function(t){t&&Object(d.a)(n.temp).then(function(t){if(100==t.code){var e=t.data;n.showErrorMessage(e)}else n.list.unshift(t.data),n.total=n.total+1,n.dialogFormVisible=!1,n.$notify({title:n.$t("table.success"),message:n.$t("table.create_success_tips"),type:"success",duration:2e3})})})},handleUpdate:function(t){var e=this;this.temp=s()({},t),this.image=this.setting.domain+t.photo,this.dialogStatus="update",this.dialogFormVisible=!0,this.$nextTick(function(){e.$refs.dataForm.clearValidate()})},updateData:function(){var c=this;this.$refs.dataForm.validate(function(t){if(t){var e=s()({},c.temp);Object(d.d)(e).then(function(t){if(100==t.code){var e=t.data;c.showErrorMessage(e)}else{var n=!0,a=!1,i=void 0;try{for(var s,o=u()(c.list);!(n=(s=o.next()).done);n=!0){var r=s.value;if(r.id===c.temp.id){var l=c.list.indexOf(r);c.list.splice(l,1,c.temp);break}}}catch(t){a=!0,i=t}finally{try{!n&&o.return&&o.return()}finally{if(a)throw i}}c.dialogFormVisible=!1,c.$notify({title:c.$t("table.success"),message:c.$t("table.update_success_tips"),type:"success",duration:2e3})}})}})},handleDelete:function(e){var n=this;this.$notify({title:this.$t("table.success"),message:this.$t("table.delete_success_tips"),type:"success",duration:2e3}),Object(d.b)({id:e.id}).then(function(){var t=n.list.indexOf(e);n.list.splice(t,1),n.total=n.total-1})},handleSizeChange:function(t){this.listQuery.limit=t,this.getList()},handleCurrentChange:function(t){this.listQuery.page=t,this.getList()},showErrorMessage:function(t){var e=this,n=[];t.map(function(t){n.push(e.$t(t))}),this.$message({message:n.join("，"),type:"error"})}}}}});