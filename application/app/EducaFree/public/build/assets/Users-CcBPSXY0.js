import{a as f,r as n,o as p,b as h,c as _,d as a,u,w as g,F as v,Z as w,e,f as b,g as x,v as y}from"./app-BCejmdRG.js";import{_ as k}from"./PanelLayout-Cgl5At89.js";import{_ as U}from"./Table-qsKmNwe9.js";import{_ as B}from"./Loading-DduPf9V5.js";import"./NavLink-De4vntQp.js";import"./logo-BolINHdd.js";import"./Modal-BCPIrcKS.js";import"./FormCourse-BLvNrFX6.js";import"./FormSection-D7l2KvY-.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./PrimaryButton-DI8czg0Y.js";import"./TextInput-p9P9VEqi.js";const D="/api/users",E=f.create({baseURL:D}),d=async(i="")=>{try{return(await E.get("/data",{params:{searchTerm:i}})).data.users}catch(r){throw console.error("Error fetching user data:",r),r}},I={class:"mb-5"},C=e("label",{for:"default-search",class:"mb-2 text-sm font-medium text-gray-900 sr-only"},"Search",-1),M={class:"relative"},S=e("div",{class:"absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"},[e("svg",{class:"w-4 h-4 text-gray-500","aria-hidden":"true",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 20 20"},[e("path",{stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"})])],-1),G={__name:"Users",setup(i){const r=n([]),o=n("");let t=n(!1);p(async()=>{try{t.value=!0,r.value=await d(),t.value=!1}catch(s){console.error("Error fetching user data:",s),t.value=!1}});async function l(){try{r.value=await d(o.value)}catch(s){console.error("Error filtering user data:",s)}}return(s,c)=>(h(),_(v,null,[a(u(w),{title:"Dashboard"}),a(k,{title:"Dashboard"},{default:g(()=>[e("div",I,[e("form",{class:"max-w-md mx-auto",onSubmit:b(l,["prevent"])},[C,e("div",M,[S,x(e("input",{type:"search",id:"default-search","onUpdate:modelValue":c[0]||(c[0]=m=>o.value=m),onInput:l,class:"block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500",placeholder:"Search...",required:""},null,544),[[y,o.value]])])],32)]),a(U,{Items:r.value,Categorie:"users"},null,8,["Items"])]),_:1}),a(B,{loading:u(t)},null,8,["loading"])],64))}};export{G as default};
