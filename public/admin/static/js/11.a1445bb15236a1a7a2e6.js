webpackJsonp([11],{1064:function(n,t,e){var a=e(1065);"string"==typeof a&&(a=[[n.i,a,""]]),a.locals&&(n.exports=a.locals);(0,e(24).default)("4ed03702",a,!0,{})},1065:function(n,t,e){(n.exports=e(19)(!1)).push([n.i,"\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n",""])},1066:function(n,t,e){"use strict";e.d(t,"a",function(){return a}),e.d(t,"b",function(){return i});var a=function(){var e=this,n=e.$createElement,a=e._self._c||n;return a("div",{staticClass:"app-container"},[a("div",{staticClass:"filter-container"},[a("el-button",{staticClass:"filter-item",staticStyle:{"margin-left":"10px"},attrs:{type:"primary",icon:"el-icon-edit"},on:{click:e.handleCreate}},[e._v(e._s(e.$t("table.add")))])],1),e._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.listLoading,expression:"listLoading"}],key:e.tableKey,staticStyle:{width:"100%"},attrs:{data:e.list,border:"",fit:"","highlight-current-row":""}},[a("el-table-column",{attrs:{label:"名称",align:"center"},scopedSlots:e._u([{key:"default",fn:function(n){return[a("span",[e._v(e._s(n.row.name))])]}}])}),e._v(" "),a("el-table-column",{attrs:{label:"Url",align:"center"},scopedSlots:e._u([{key:"default",fn:function(n){return[a("span",[e._v(e._s(n.row.url))])]}}])}),e._v(" "),a("el-table-column",{attrs:{label:"Tab",align:"center"},scopedSlots:e._u([{key:"default",fn:function(n){return[a("span",[e._v(e._s(n.row.tab))])]}}])}),e._v(" "),a("el-table-column",{attrs:{label:"类别",align:"center"},scopedSlots:e._u([{key:"default",fn:function(n){return[a("span",[e._v(e._s(n.row.cat))])]}}])}),e._v(" "),a("el-table-column",{attrs:{label:e.$t("table.actions"),align:"center",width:"230","class-name":"small-padding fixed-width"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(n){e.handleUpdate(t.row)}}},[e._v(e._s(e.$t("table.edit")))]),e._v(" "),a("el-popover",{attrs:{placement:"top",width:"160"},model:{value:t.row.del,callback:function(n){e.$set(t.row,"del",n)},expression:"scope.row.del"}},[a("p",[e._v(e._s(e.$t("table.del_tips")))]),e._v(" "),a("div",{staticStyle:{"text-align":"right",margin:"0"}},[a("el-button",{attrs:{size:"mini",type:"text"},on:{click:function(n){t.row.del=!1}}},[e._v(e._s(e.$t("table.cancel")))]),e._v(" "),a("el-button",{attrs:{size:"mini",type:"primary"},on:{click:function(n){e.handleDelete(t.row)}}},[e._v(e._s(e.$t("table.confirm")))])],1),e._v(" "),a("el-button",{attrs:{slot:"reference",size:"mini",type:"danger"},on:{click:function(n){t.row.del=!0}},slot:"reference"},[e._v(e._s(e.$t("table.delete")))])],1)]}}])})],1),e._v(" "),a("div",{staticClass:"pagination-container"},[a("el-pagination",{directives:[{name:"show",rawName:"v-show",value:0<e.total,expression:"total>0"}],attrs:{"current-page":e.listQuery.page,"page-size":e.listQuery.limit,total:e.total,background:"",layout:"total, prev, pager, next, jumper"},on:{"size-change":e.handleSizeChange,"current-change":e.handleCurrentChange}})],1),e._v(" "),a("el-dialog",{attrs:{title:e.textMap[e.dialogStatus],visible:e.dialogFormVisible,width:"60%"},on:{"update:visible":function(n){e.dialogFormVisible=n}}},[a("el-form",{ref:"dataForm",staticStyle:{width:"80%","margin-left":"50px"},attrs:{rules:e.rules,model:e.temp,"label-position":"left","label-width":"80px"}},[a("el-form-item",{attrs:{label:"名称",prop:"name"}},[a("el-input",{model:{value:e.temp.name,callback:function(n){e.$set(e.temp,"name",n)},expression:"temp.name"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"Url",prop:"url"}},[a("el-input",{model:{value:e.temp.url,callback:function(n){e.$set(e.temp,"url",n)},expression:"temp.url"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"Tab",prop:"tab"}},[a("el-input",{model:{value:e.temp.tab,callback:function(n){e.$set(e.temp,"tab",n)},expression:"temp.tab"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"翻译",prop:"translation"}},[a("el-input",{attrs:{type:"textarea",autosize:{minRows:8,maxRows:8}},model:{value:e.temp.translation,callback:function(n){e.$set(e.temp,"translation",n)},expression:"temp.translation"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"类别",prop:"catId"}},[a("el-select",{attrs:{placeholder:"请选择"},model:{value:e.temp.catId,callback:function(n){e.$set(e.temp,"catId",n)},expression:"temp.catId"}},e._l(e.VoiceCat,function(n,t){return a("el-option",{key:t,attrs:{label:n.label,value:n.value}})}))],1)],1),e._v(" "),a("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(n){e.dialogFormVisible=!1}}},[e._v(e._s(e.$t("table.cancel")))]),e._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:function(n){"create"===e.dialogStatus?e.createData():e.updateData()}}},[e._v(e._s(e.$t("table.confirm")))])],1)],1)],1)},i=[]},432:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=e(685),i=e(1066),s=e(4);var l=function(n){e(1064)},o=Object(s.a)(a.a,i.a,i.b,!1,l,null,null);t.default=o.exports},442:function(n,t,e){"use strict";var a=e(443),i=function(n){Vue.directive("waves",a.a)};window.Vue&&(window.waves=a.a,Vue.use(i)),a.a.install=i,t.a=a.a},443:function(n,t,e){"use strict";var a=e(84),r=e.n(a),i=e(444);e.n(i);t.a={bind:function(l,o){l.addEventListener("click",function(n){var t=r()({},o.value),e=r()({ele:l,type:"hit",color:"rgba(0, 0, 0, 0.15)"},t),a=e.ele;if(a){a.style.position="relative",a.style.overflow="hidden";var i=a.getBoundingClientRect(),s=a.querySelector(".waves-ripple");switch(s?s.className="waves-ripple":((s=document.createElement("span")).className="waves-ripple",s.style.height=s.style.width=Math.max(i.width,i.height)+"px",a.appendChild(s)),e.type){case"center":s.style.top=i.height/2-s.offsetHeight/2+"px",s.style.left=i.width/2-s.offsetWidth/2+"px";break;default:s.style.top=(n.pageY-i.top-s.offsetHeight/2-document.documentElement.scrollTop||document.body.scrollTop)+"px",s.style.left=(n.pageX-i.left-s.offsetWidth/2-document.documentElement.scrollLeft||document.body.scrollLeft)+"px"}return s.style.backgroundColor=e.color,!(s.className="waves-ripple z-active")}},!1)}}},444:function(n,t,e){var a=e(445);"string"==typeof a&&(a=[[n.i,a,""]]),a.locals&&(n.exports=a.locals);(0,e(24).default)("0b24217a",a,!0,{})},445:function(n,t,e){(n.exports=e(19)(!1)).push([n.i,".waves-ripple {\n    position: absolute;\n    border-radius: 100%;\n    background-color: rgba(0, 0, 0, 0.15);\n    background-clip: padding-box;\n    pointer-events: none;\n    -webkit-user-select: none;\n    -moz-user-select: none;\n    -ms-user-select: none;\n    user-select: none;\n    -webkit-transform: scale(0);\n    -ms-transform: scale(0);\n    transform: scale(0);\n    opacity: 1;\n}\n\n.waves-ripple.z-active {\n    opacity: 0;\n    -webkit-transform: scale(2);\n    -ms-transform: scale(2);\n    transform: scale(2);\n    -webkit-transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, -webkit-transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out;\n    transition: opacity 1.2s ease-out, transform 0.6s ease-out, -webkit-transform 0.6s ease-out;\n}",""])},545:function(n,t,e){"use strict";t.e=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.get("/v1/voice_cat/list",n)},t.b=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/voice_cat/create",n)},t.i=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/voice_cat/update",n)},t.d=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/voice_cat/delete",n)},t.g=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.get("/v1/voice_cat/items",n)},t.f=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.get("/v1/voice/list",n)},t.a=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/voice/create",n)},t.h=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/voice/update",n)},t.c=function(){var n=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};return a.a.post("/v1/voice/delete",n)};var a=e(30)},685:function(n,t,e){"use strict";var a=e(49),u=e.n(a),i=e(84),s=e.n(i),l=e(442),o=e(545);t.a={name:"Voice",directives:{waves:l.a},data:function(){return{tableKey:0,list:null,total:0,listLoading:!1,listQuery:{page:1,limit:20,sortOrder:"ascend",filters:{}},sortOptions:[{label:"ID Ascending",key:"ascend"},{label:"ID Descending",key:"descend"}],image:"",temp:{name:"",url:"",tab:"",catId:"",translation:""},VoiceCat:[],dialogFormVisible:!1,dialogStatus:"",textMap:{update:this.$t("table.edit"),create:this.$t("table.add")},rules:{name:[{required:!0,message:this.$t("table.required"),trigger:"change"}],url:[{required:!0,message:this.$t("table.required"),trigger:"change"}],catId:[{required:!0,message:this.$t("table.required"),trigger:"change"}]}}},created:function(){this.getList(),this.getVoiceCat()},methods:{getList:function(){var t=this;this.listLoading=!0,Object(o.f)(this.listQuery).then(function(n){t.list=n.data.items,t.total=n.data.pagination.total,t.listLoading=!1})},getVoiceCat:function(){var t=this;Object(o.g)().then(function(n){t.VoiceCat=n.data})},resetTemp:function(){this.temp={name:"",url:"",tab:"",catId:"",translation:""}},handleCreate:function(){var n=this;this.resetTemp(),this.dialogStatus="create",this.dialogFormVisible=!0,this.$nextTick(function(){n.$refs.dataForm.clearValidate()})},createData:function(){var e=this;this.$refs.dataForm.validate(function(n){n&&Object(o.a)(e.temp).then(function(n){if(100==n.code){var t=n.data;e.showErrorMessage(t)}else e.list.unshift(n.data),e.total=e.total+1,e.dialogFormVisible=!1,e.$notify({title:e.$t("table.success"),message:e.$t("table.create_success_tips"),type:"success",duration:2e3})})})},handleUpdate:function(n){var t=this;this.temp=s()({},n),this.dialogStatus="update",this.dialogFormVisible=!0,this.$nextTick(function(){t.$refs.dataForm.clearValidate()})},updateData:function(){var c=this;this.$refs.dataForm.validate(function(n){if(n){var t=s()({},c.temp);Object(o.h)(t).then(function(n){if(100==n.code){var t=n.data;c.showErrorMessage(t)}else{var e=!0,a=!1,i=void 0;try{for(var s,l=u()(c.list);!(e=(s=l.next()).done);e=!0){var o=s.value;if(o.id===c.temp.id){var r=c.list.indexOf(o);c.temp.cat=n.data.cat,c.list.splice(r,1,c.temp);break}}}catch(n){a=!0,i=n}finally{try{!e&&l.return&&l.return()}finally{if(a)throw i}}c.dialogFormVisible=!1,c.$notify({title:c.$t("table.success"),message:c.$t("table.update_success_tips"),type:"success",duration:2e3})}})}})},handleDelete:function(t){var e=this;this.$notify({title:this.$t("table.success"),message:this.$t("table.delete_success_tips"),type:"success",duration:2e3}),Object(o.c)({id:t.id}).then(function(){var n=e.list.indexOf(t);e.list.splice(n,1),e.total=e.total-1})},handleSizeChange:function(n){this.listQuery.limit=n,this.getList()},handleCurrentChange:function(n){this.listQuery.page=n,this.getList()},showErrorMessage:function(n){var t=this,e=[];n.map(function(n){e.push(t.$t(n))}),this.$message({message:e.join("，"),type:"error"})}}}}});