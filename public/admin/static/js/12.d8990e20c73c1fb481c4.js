webpackJsonp([12],{1061:function(n,t,e){var i=e(1062);"string"==typeof i&&(i=[[n.i,i,""]]),i.locals&&(n.exports=i.locals);(0,e(24).default)("ff55c082",i,!0,{})},1062:function(n,t,e){(n.exports=e(19)(!1)).push([n.i,"\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n",""])},1063:function(n,t,e){"use strict";e.d(t,"a",function(){return i}),e.d(t,"b",function(){return a});var i=function(){var e=this,n=e.$createElement,i=e._self._c||n;return i("div",{staticClass:"app-container"},[i("div",{staticClass:"filter-container"},[i("el-button",{staticClass:"filter-item",staticStyle:{"margin-left":"10px"},attrs:{type:"primary",icon:"el-icon-edit"},on:{click:e.handleCreate}},[e._v(e._s(e.$t("table.add")))])],1),e._v(" "),i("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.listLoading,expression:"listLoading"}],key:e.tableKey,staticStyle:{width:"100%"},attrs:{data:e.list,border:"",fit:"","highlight-current-row":""}},[i("el-table-column",{attrs:{label:e.$t("table.name"),align:"center","min-width":"150"},scopedSlots:e._u([{key:"default",fn:function(n){return[i("span",[e._v(e._s(n.row.title))])]}}])}),e._v(" "),i("el-table-column",{attrs:{label:e.$t("table.actions"),align:"center",width:"230","class-name":"small-padding fixed-width"},scopedSlots:e._u([{key:"default",fn:function(t){return[i("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(n){e.handleUpdate(t.row)}}},[e._v(e._s(e.$t("table.edit")))]),e._v(" "),i("el-popover",{attrs:{placement:"top",width:"160"},model:{value:t.row.del,callback:function(n){e.$set(t.row,"del",n)},expression:"scope.row.del"}},[i("p",[e._v(e._s(e.$t("table.del_tips")))]),e._v(" "),i("div",{staticStyle:{"text-align":"right",margin:"0"}},[i("el-button",{attrs:{size:"mini",type:"text"},on:{click:function(n){t.row.del=!1}}},[e._v(e._s(e.$t("table.cancel")))]),e._v(" "),i("el-button",{attrs:{size:"mini",type:"primary"},on:{click:function(n){e.handleDelete(t.row)}}},[e._v(e._s(e.$t("table.confirm")))])],1),e._v(" "),i("el-button",{attrs:{slot:"reference",size:"mini",type:"danger"},on:{click:function(n){t.row.del=!0}},slot:"reference"},[e._v(e._s(e.$t("table.delete")))])],1)]}}])})],1),e._v(" "),i("div",{staticClass:"pagination-container"},[i("el-pagination",{directives:[{name:"show",rawName:"v-show",value:0<e.total,expression:"total>0"}],attrs:{"current-page":e.listQuery.page,"page-size":e.listQuery.limit,total:e.total,background:"",layout:"total, prev, pager, next, jumper"},on:{"size-change":e.handleSizeChange,"current-change":e.handleCurrentChange}})],1),e._v(" "),i("el-dialog",{attrs:{title:e.textMap[e.dialogStatus],visible:e.dialogFormVisible,width:"60%"},on:{"update:visible":function(n){e.dialogFormVisible=n}}},[i("el-form",{ref:"dataForm",staticStyle:{width:"80%","margin-left":"50px"},attrs:{rules:e.rules,model:e.temp,"label-position":"left","label-width":"80px"}},[i("el-form-item",{attrs:{label:e.$t("table.name"),prop:"title"}},[i("el-input",{model:{value:e.temp.title,callback:function(n){e.$set(e.temp,"title",n)},expression:"temp.title"}})],1)],1),e._v(" "),i("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{on:{click:function(n){e.dialogFormVisible=!1}}},[e._v(e._s(e.$t("table.cancel")))]),e._v(" "),i("el-button",{attrs:{type:"primary"},on:{click:function(n){"create"===e.dialogStatus?e.createData():e.updateData()}}},[e._v(e._s(e.$t("table.confirm")))])],1)],1)],1)},a=[]},431:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i=e(685),a=e(1063),s=e(4);var o=function(n){e(1061)},l=Object(s.a)(i.a,a.a,a.b,!1,o,null,null);t.default=l.exports},442:function(n,t,e){"use strict";var i=e(443),a=function(n){Vue.directive("waves",i.a)};window.Vue&&(window.waves=i.a,Vue.use(a)),i.a.install=a,t.a=i.a},443:function(n,t,e){"use strict";var i=e(84),r=e.n(i),a=e(444);e.n(a);t.a={bind:function(o,l){o.addEventListener("click",function(n){var t=r()({},l.value),e=r()({ele:o,type:"hit",color:"rgba(0, 0, 0, 0.15)"},t),i=e.ele;if(i){i.style.position="relative",i.style.overflow="hidden";var a=i.getBoundingClientRect(),s=i.querySelector(".waves-ripple");switch(s?s.className="waves-ripple":((s=document.createElement("span")).className="waves-ripple",s.style.height=s.style.width=Math.max(a.width,a.height)+"px",i.appendChild(s)),e.type){case"center":s.style.top=a.height/2-s.offsetHeight/2+"px",s.style.left=a.width/2-s.offsetWidth/2+"px";break;default:s.style.top=(n.pageY-a.top-s.offsetHeight/2-document.documentElement.scrollTop||document.body.scrollTop)+"px",s.style.left=(n.pageX-a.left-s.offsetWidth/2-document.documentElement.scrollLeft||document.body.scrollLeft)+"px"}return s.style.backgroundColor=e.color,!(s.className="waves-ripple z-active")}},!1)}}},444:function(n,t,e){var i=e(445);"string"==typeof i&&(i=[[n.i,i,""]]),i.locals&&(n.exports=i.locals);(0,e(24).default)("0b24217a",i,!0,{})},445:function(n,t,e){(n.exports=e(19)(!1)).push([n.i,".waves-ripple {\n    position: absolute;\n    border-radius: 100%;\n    background-color: rgba(0, 0, 0, 0.15);\n    background-clip: padding-box;\n    pointer-events: none;\n    -webkit-user-select: none;\n    -moz-user-select: none;\n    -ms-user-select: none;\n    user-select: none;\n    -webkit-transform: scale(0);\n    -ms-transform: scale(0);\n    transform: scale(0);\n    opacity: 1;\n}\n\n.waves-ripple.z-active {\n    opacity: 0;\n    -webkit-transform: scale(2);\n    -ms-transform: scale(2);\n    transform: scale(2);\n    -webkit-transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out, -webkit-transform 0.6s ease-out;\n}",""])},545:function(n,t,e){"use strict";t.e=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/voice_cat/list",n)},t.b=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/voice_cat/create",n)},t.i=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/voice_cat/update",n)},t.d=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/voice_cat/delete",n)},t.g=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/voice_cat/items",n)},t.f=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.get("/v1/voice/list",n)},t.a=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/voice/create",n)},t.h=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/voice/update",n)},t.c=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return i.a.post("/v1/voice/delete",n)};var i=e(30)},685:function(n,t,e){"use strict";var i=e(49),u=e.n(i),a=e(84),s=e.n(a),o=e(442),l=e(545);t.a={name:"VoiceCat",directives:{waves:o.a},data:function(){return{tableKey:0,list:null,total:0,listLoading:!1,listQuery:{page:1,limit:20,sortOrder:"ascend",filters:{name:void 0}},sortOptions:[{label:"ID Ascending",key:"ascend"},{label:"ID Descending",key:"descend"}],temp:{title:""},dialogFormVisible:!1,dialogStatus:"",textMap:{update:this.$t("table.edit"),create:this.$t("table.add")},rules:{title:[{required:!0,message:this.$t("table.required"),trigger:"change"}]}}},created:function(){this.getList()},methods:{getList:function(){var t=this;this.listLoading=!0,Object(l.e)(this.listQuery).then(function(n){t.list=n.data.items,t.total=n.data.pagination.total,t.listLoading=!1})},resetTemp:function(){this.temp={title:""}},handleCreate:function(){var n=this;this.resetTemp(),this.dialogStatus="create",this.dialogFormVisible=!0,this.$nextTick(function(){n.$refs.dataForm.clearValidate()})},createData:function(){var e=this;this.$refs.dataForm.validate(function(n){n&&Object(l.b)(e.temp).then(function(n){if(100==n.code){var t=n.data;e.showErrorMessage(t)}else e.list.unshift(n.data),e.total=e.total+1,e.dialogFormVisible=!1,e.$notify({title:e.$t("table.success"),message:e.$t("table.create_success_tips"),type:"success",duration:2e3})})})},handleUpdate:function(n){var t=this;this.temp=s()({},n),this.dialogStatus="update",this.dialogFormVisible=!0,this.$nextTick(function(){t.$refs.dataForm.clearValidate()})},updateData:function(){var c=this;this.$refs.dataForm.validate(function(n){if(n){var t=s()({},c.temp);Object(l.i)(t).then(function(n){if(100==n.code){var t=n.data;c.showErrorMessage(t)}else{var e=!0,i=!1,a=void 0;try{for(var s,o=u()(c.list);!(e=(s=o.next()).done);e=!0){var l=s.value;if(l.id===c.temp.id){var r=c.list.indexOf(l);c.list.splice(r,1,c.temp);break}}}catch(n){i=!0,a=n}finally{try{!e&&o.return&&o.return()}finally{if(i)throw a}}c.dialogFormVisible=!1,c.$notify({title:c.$t("table.success"),message:c.$t("table.update_success_tips"),type:"success",duration:2e3})}})}})},handleDelete:function(t){var e=this;this.$notify({title:this.$t("table.success"),message:this.$t("table.delete_success_tips"),type:"success",duration:2e3}),Object(l.d)({id:t.id}).then(function(){var n=e.list.indexOf(t);e.list.splice(n,1),e.total=e.total-1})},handleSizeChange:function(n){this.listQuery.limit=n,this.getList()},handleCurrentChange:function(n){this.listQuery.page=n,this.getList()},showErrorMessage:function(n){var t=this,e=[];n.map(function(n){e.push(t.$t(n))}),this.$message({message:e.join("，"),type:"error"})}}}}});