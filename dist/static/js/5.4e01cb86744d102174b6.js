webpackJsonp([5],{FWJt:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n("mtWM"),a=n.n(o),s={data:function(){return{accounts:[]}},methods:{addRow:function(){var t={username:"",password:"",key:Date.now(),show:1};this.accounts.push(t)},save:function(){var t=this,e=this.$loading.show({width:50,height:50,container:null});a.a.put("http://localhost:8080/admin/api/icloud.php",{accounts:this.accounts.map(function(t){return{username:t.username,password:t.password,show:t.show}})}).then(function(t){return t.data}).then(function(e){if(console.log(e),0!=e.error)throw new Error(e.mess);t.$notify({group:"App",width:"100%",position:"top left",title:"Successfully",text:"Cập nhật thành công",type:"success"})}).catch(function(e){console.log(e),t.$notify({group:"App",width:"100%",position:"top left",title:e.message,text:e.stack,type:"error"})}).finally(function(){return e.hide()})},remove:function(t){this.accounts.splice(t,1)}},created:function(){var t=this,e=this.$loading.show({width:50,height:50,container:null});a.a.get("http://localhost:8080/admin/api/icloud.php").then(function(t){return t.data}).then(function(e){console.log(e),e.map(function(t){"key"in t||(t.key=Date.now()+Math.random())}),t.accounts=e}).catch(function(e){t.$once("hook:mounted",function(){t.$notify({group:"App",width:"100%",position:"top left",title:e.message,message:e.stack,type:"error"})})}).finally(function(){return e.hide()})},mounted:function(){this.$emit("hook:mounted")}},i={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"main"},[n("form",{staticClass:"my-2 was-validated",on:{submit:function(e){return e.preventDefault(),t.update(e.target)}}},[n("label",[t._v(" Các tài khoản ")]),t._v(" "),n("transition-group",{tag:"table",staticClass:"table-responsive",attrs:{name:"slide",tag:"table"}},t._l(t.accounts,function(e,o){return n("tr",{key:e.key},[n("td",[n("input",{directives:[{name:"model",rawName:"v-model",value:e.username,expression:"item.username"}],staticClass:"no-input form-control",attrs:{name:"username[]",required:"",placeholder:"Username"},domProps:{value:e.username},on:{input:function(n){n.target.composing||t.$set(e,"username",n.target.value)}}})]),t._v(" "),n("td",[n("input",{directives:[{name:"model",rawName:"v-model",value:e.password,expression:"item.password"}],staticClass:"no-input form-control",attrs:{name:"password[]",required:"",placeholder:"Password"},domProps:{value:e.password},on:{input:function(n){n.target.composing||t.$set(e,"password",n.target.value)}}})]),t._v(" "),n("td",{staticClass:"icon",on:{click:function(t){e.show=e.show?0:1}}},[n("i",{class:["fas",1==e.show?"fa-eye":"fa-eye-slash"]})]),t._v(" "),n("td",{staticClass:"icon",on:{click:function(e){return t.remove(o)}}},[n("i",{staticClass:"fad fa-trash"})])])}),0),t._v(" "),0==t.accounts.length?n("div",{staticClass:"text-center text-secondary py-3"},[t._v("\n         Không có tài khoản nào\n      ")]):t._e()],1),t._v(" "),n("vue-fab",{attrs:{icon:"toc","main-btn-color":"#999",size:"big","fab-item-animate":"alive"}},[n("fab-item",{attrs:{icon:"save",color:"#c7d23b",idx:0},on:{clickItem:t.save}}),t._v(" "),n("fab-item",{attrs:{icon:"add",idx:1},on:{clickItem:t.addRow}})],1)],1)},staticRenderFns:[]};var r=n("VU/8")(s,i,!1,function(t){n("kj3J")},"data-v-522c5aa7",null);e.default=r.exports},kj3J:function(t,e){}});
//# sourceMappingURL=5.4e01cb86744d102174b6.js.map