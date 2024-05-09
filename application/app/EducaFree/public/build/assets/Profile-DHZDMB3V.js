import{_ as j}from"./Modal-BCPIrcKS.js";import{b as d,c as u,d as s,w as l,k as x,e,m as M,r as y,a as D,T as $,u as g,F as V,Z as z,t as f,i as R,j as F,n as O}from"./app-BCejmdRG.js";import{_ as T}from"./Layout-CxyR9L1k.js";import{_ as P}from"./FormSection-D7l2KvY-.js";import{_ as h,a as S}from"./PrimaryButton-DI8czg0Y.js";import{_ as v,a as _}from"./TextInput-p9P9VEqi.js";import"./logo-BolINHdd.js";import"./NavLink-De4vntQp.js";import"./ToggleDark-CpMMCBhr.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const q={class:"container px-5 py-8 mx-auto"},E={class:"col-span-6 md:col-span-6"},A={__name:"updateInfo",props:{form:{type:Object,required:!0},name:String,email:String},emits:["submit"],setup(t){const o=t;return o.form.name=o.name,o.form.email=o.email,(r,a)=>(d(),u("div",q,[s(P,{onSubmitted:a[2]||(a[2]=m=>r.$emit("submit"))},{title:l(()=>[x(" Update your user info ")]),form:l(()=>[e("div",E,[s(v,{for:"name",value:"Name",class:"mt-3"}),s(_,{id:"name",modelValue:t.form.name,"onUpdate:modelValue":a[0]||(a[0]=m=>t.form.name=m),type:"text",autocomplete:"user-name",class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"},null,8,["modelValue"]),s(h,{message:r.$page.props.errors.name,class:"mt-2"},null,8,["message"]),s(v,{for:"email",value:"Email",class:"mt-3"}),s(_,{id:"email",modelValue:t.form.email,"onUpdate:modelValue":a[1]||(a[1]=m=>t.form.email=m),type:"email",autocomplete:"user-email",class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"},null,8,["modelValue"]),s(h,{message:r.$page.props.errors.email,class:"mt-2"},null,8,["message"])])]),actions:l(()=>[s(S,{class:"mt-2"},{default:l(()=>[x(" Update ")]),_:1})]),_:1})]))}},L={class:"container px-5 py-8 mx-auto"},W={class:"col-span-6 sm:col-span-6"},H={__name:"updatePassword",props:{form:{type:Object,required:!0},id:Number},emits:["submit"],setup(t){return(o,r)=>(d(),u("div",L,[s(P,{onSubmitted:r[3]||(r[3]=a=>o.$emit("submit"))},{title:l(()=>[x(" Update your password ")]),form:l(()=>[e("div",W,[s(v,{for:"currentPassword",value:"Current password"}),s(_,{id:"currentPassword",modelValue:t.form.currentPassword,"onUpdate:modelValue":r[0]||(r[0]=a=>t.form.currentPassword=a),type:"password",autocomplete:"user-currentPassword",class:"mt-1 block w-full"},null,8,["modelValue"]),s(h,{message:o.$page.props.errors.currentPassword,class:"mt-2"},null,8,["message"]),s(v,{for:"newPassword",value:"New password",class:"mt-3"}),s(_,{id:"newPassword",modelValue:t.form.newPassword,"onUpdate:modelValue":r[1]||(r[1]=a=>t.form.newPassword=a),type:"password",autocomplete:"user-newPassword",class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"},null,8,["modelValue"]),s(h,{message:o.$page.props.errors.newPassword,class:"mt-2"},null,8,["message"]),s(v,{for:"repeatPassword",value:"Repeat new password",class:"mt-3"}),s(_,{id:"repeatPassword",modelValue:t.form.repeatPassword,"onUpdate:modelValue":r[2]||(r[2]=a=>t.form.repeatPassword=a),type:"password",autocomplete:"user-repeatPassword",class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"},null,8,["modelValue"]),s(h,{message:o.$page.props.errors.repeatPassword,class:"mt-2"},null,8,["message"])])]),actions:l(()=>[s(S,{class:"mt-2"},{default:l(()=>[x(" Update Password ")]),_:1})]),_:1})]))}},Y=["type"],Z={__name:"DeleteButton",props:{type:{type:String,default:"submit"}},setup(t){return(o,r)=>(d(),u("button",{type:t.type,class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"},[M(o.$slots,"default")],8,Y))}},G={class:"container px-5 py-8 mx-auto"},J=e("div",{class:"col-span-6 sm:col-span-6"},[e("p",null,[x("I'm going to delete my own user account. By doing this, all my personal information, including my name, email, and any associated data, will be permanently removed from the system."),e("br"),e("br"),x(" This action cannot be undone.")])],-1),K={class:"p-4 md:p-5 text-center"},Q=e("svg",{class:"mx-auto mb-4 text-gray-400 w-12 h-12","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 20 20"},[e("path",{stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"})],-1),X=e("h3",{class:"mb-5 text-lg font-normal text-gray-500 dark:text-gray-200"},"Are you sure you want to delete your account?",-1),ee={__name:"deleteAccount",props:{form:{type:Object,required:!0}},emits:["submit"],setup(t){const o=y(!1),r=y(null),a=m=>{o.value=!0,r.value=m};return(m,n)=>(d(),u("div",G,[s(P,{onSubmitted:n[3]||(n[3]=b=>m.$emit("submit"))},{title:l(()=>[x(" Delete your account ")]),form:l(()=>[J]),actions:l(()=>[s(j,{show:o.value,onClose:n[1]||(n[1]=b=>o.value=!1),maxWidth:"sm"},{default:l(()=>[e("div",K,[Q,X,s(Z,null,{default:l(()=>[x(" Yes, delete ")]),_:1}),e("button",{onClick:n[0]||(n[0]=b=>o.value=!1),type:"button",class:"py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"},"No, cancel")])]),_:1},8,["show"]),e("a",{class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer",onClick:n[2]||(n[2]=b=>a(m.$page.props.auth.user.id))}," Delete ")]),_:1})]))}},te="/api/ranking",se=D.create({baseURL:te}),oe=async()=>{try{return(await se.get("/data/")).data}catch(t){throw console.error("Error fetching course info data:",t),t}},re={class:"pb-10"},ae={class:"mx-auto bg-white h-[37rem] sm:h-[22rem] flex justify-end content-center flex-col shadow-lg dark:bg-zinc-700 dark:text-white"},ne={class:"mt-5 mb-10 text-center text-4xl font-[1000]"},le=e("span",null,null,-1),ie={class:"flex flex-col sm:flex-row justify-around p-4"},de={class:"flex flex-col items-center justify-center"},ue={class:"mb-2 text-3xl font-extrabold"},me=e("div",{class:"text-gray-500 dark:text-gray-200"},"Started Courses",-1),ce={class:"flex flex-col items-center justify-center"},fe={class:"mb-2 text-3xl font-extrabold"},pe=e("div",{class:"text-gray-500 dark:text-gray-200"},"Completed Courses",-1),ge={class:"flex flex-col items-center justify-center"},xe={class:"mb-2 text-3xl font-extrabold"},be=e("div",{class:"text-gray-500 dark:text-gray-200"},"Favorites Courses",-1),we={class:"flex flex-col items-center justify-center"},ye={class:"mb-2 text-3xl font-extrabold"},he=e("div",{class:"text-gray-500 dark:text-gray-200"},"Time Learning",-1),ve={class:"flex flex-col items-center justify-cente dark:bg-zinc-700r"},_e={key:0,class:"mb-2 text-5xl md:text-5xl text-amber-400 font-extrabold"},ke={key:1,class:"mb-2 text-5xl text-slate-300 font-extrabold"},$e={key:2,class:"mb-2 text-5xl text-amber-600 font-extrabold"},Pe={key:3,class:"mb-2 text-5xl font-extrabold"},Ce={key:4,class:"mb-2 text-5xl font-extrabold"},Ve={class:"container px-5 py-8 mx-auto dark:bg-zinc-700 dark:text-white max-w-[80rem]"},Re={id:"updateInfo",class:"border-b dark:border-gray-600 p-2"},je={id:"updatePassword",class:"border-b dark:border-gray-600 p-2"},Se={id:"deleteUser",class:"p-2"},Ne=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"35",height:"35",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1","stroke-linecap":"square","stroke-linejoin":"bevel"},[e("line",{x1:"18",y1:"6",x2:"6",y2:"18"}),e("line",{x1:"6",y1:"6",x2:"18",y2:"18"})],-1),Ue=[Ne],Ie={class:"relative overflow-x-auto shadow-md sm:rounded-lg"},Be={class:"w-full text-sm text-left text-gray-500"},Me=e("thead",{class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700"},[e("tr",null,[e("th",{scope:"col",class:"px-6 py-3"}," Ranking "),e("th",{scope:"col",class:"px-6 py-3"}," Name "),e("th",{scope:"col",class:"px-6 py-3 text-right"}," Completed Courses ")])],-1),De={class:"odd:bg-white even:bg-gray-50 border-b dark:border-gray-600"},ze={class:"px-6 py-4"},Fe={class:"px-6 py-4 text-center"},Oe={key:1},Te=e("td",{colspan:"5",class:"px-6 py-4 text-center"}," Nothing to show here! ",-1),qe=[Te],Qe={__name:"Profile",props:{sessions:Array,coursesInfo:Object,userRank:Number,favorites:Object},setup(t){const o=t,r=$({name:"",email:""}),a=$({currentPassword:"",newPassword:"",repeatPassword:""}),m=$({id:""});let n=y(!1),b=y([]);const k=y([]),C=y([]);C.value=o.favorites,k.value=o.coursesInfo;function N(){return k.value.filter(i=>i.progress==100).length||"0"}function U(){return C.value.length}const I=async()=>{b.value=await oe(),n.value=!0};function B(){let i=0;return k.value.forEach(c=>{const p=c;if(p){const w=p.progress/100*p.course.lessons_count*15;i+=w/60}}),i.toFixed(2)}return(i,c)=>(d(),u(V,null,[s(g(z),{title:"Profile"}),s(T,{title:"Profile"},{default:l(()=>[e("div",re,[e("section",ae,[e("p",ne,[x("Welcome to your profile "),le,x(f(i.$page.props.auth.user.name)+" !",1)]),e("div",ie,[e("div",de,[e("div",ue,f(k.value.length),1),me]),e("div",ce,[e("div",fe,f(N()),1),pe]),e("div",ge,[e("div",xe,f(U()),1),be]),e("div",we,[e("div",ye,"~ "+f(B())+" hr",1),he]),e("div",ve,[t.userRank==1?(d(),u("div",_e,f(t.userRank),1)):t.userRank==2?(d(),u("div",ke,f(t.userRank),1)):t.userRank==3?(d(),u("div",$e,f(t.userRank),1)):t.userRank>3?(d(),u("div",Pe,f(t.userRank),1)):(d(),u("div",Ce,"NR")),e("div",{class:"text-blue-500 cursor-pointer underline",onClick:I},"Ranking")])])])]),e("div",Ve,[e("section",Re,[s(A,{form:g(r),onSubmit:c[0]||(c[0]=p=>g(r).put(i.route("user.update",i.$page.props.auth.user.id))),name:i.$page.props.auth.user.name,email:i.$page.props.auth.user.email},null,8,["form","name","email"])]),e("section",je,[s(H,{form:g(a),onSubmit:c[1]||(c[1]=p=>g(a).put(i.route("user.updatePassword",i.$page.props.auth.user.id)))},null,8,["form"])]),e("section",Se,[s(ee,{form:g(m),onSubmit:c[2]||(c[2]=p=>g(m).delete(i.route("user.deleteYourself",i.$page.props.auth.user.id)))},null,8,["form"])])]),s(j,{show:g(n),onClose:c[4]||(c[4]=p=>R(n)?n.value=!1:n=!1),maxWidth:"md"},{default:l(()=>[e("a",{onClick:c[3]||(c[3]=p=>R(n)?n.value=!1:n=!1),class:"hover:text-red-500 cursor-pointer dark:hover:text-red-500 dark:text-white"},Ue),e("div",Ie,[e("table",Be,[Me,e("tbody",null,[g(b).length>0?(d(!0),u(V,{key:0},F(g(b),(p,w)=>(d(),u("tr",De,[e("th",{scope:"row",class:O(["px-6 py-4 font-medium text-gray-900 whitespace-nowrap",{"bg-yellow-200":w===0,"bg-slate-200":w===1,"bg-amber-600":w===2,"text-gray-900":w>2}])},f(w+1),3),e("td",ze,f(p.name),1),e("td",Fe,f(p.courses_info_count),1)]))),256)):(d(),u("tr",Oe,qe))])])])]),_:1},8,["show"])]),_:1})],64))}};export{Qe as default};