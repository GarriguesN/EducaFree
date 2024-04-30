import{T as b,b as n,q as h,w as m,d as a,u as t,Z as g,e,c as w,t as x,h as v,f as k,k as d,n as c}from"./app-BCejmdRG.js";import{_ as u,a as y}from"./PrimaryButton-DI8czg0Y.js";import{_ as f,a as p}from"./TextInput-p9P9VEqi.js";import{_ as V}from"./AuthLayout-eiwe6ham.js";import{l as j}from"./logo-BolINHdd.js";import"./ToggleDark-CpMMCBhr.js";const L={class:"flex items-center justify-center pt-1 pb-10"},$=["src"],B=e("span",{class:"self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500"},"EducaFree",-1),C={key:0,class:"mb-4 font-medium text-sm text-green-600 text-center"},N={class:"mt-4"},q={class:"flex items-center justify-center mt-10"},z={class:"flex items-center justify-center mt-10"},E=["href"],F={class:"flex items-center justify-center mt-10"},S=["href"],A={__name:"Login",props:{status:String},setup(l){const s=b({email:"",password:""}),_=()=>{s.transform(o=>({...o,remember:s.remember?"on":""})).post(route("login"),{onFinish:()=>s.reset("password")})};return(o,r)=>(n(),h(V,{title:"Login"},{default:m(()=>[a(t(g),{title:"Log in"}),e("div",{class:c(["border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[36rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white",{"md:h-[36rem]":l.status}])},[e("div",L,[e("img",{src:t(j),alt:"Logo",class:"h-8 mr-2"},null,8,$),B]),l.status?(n(),w("div",C,x(l.status),1)):v("",!0),e("form",{onSubmit:k(_,["prevent"]),class:"h-full"},[e("div",null,[a(f,{for:"email",value:"Email"}),a(p,{id:"email",modelValue:t(s).email,"onUpdate:modelValue":r[0]||(r[0]=i=>t(s).email=i),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(u,{class:"mt-2",message:t(s).errors.email},null,8,["message"])]),e("div",N,[a(f,{for:"password",value:"Password"}),a(p,{id:"password",modelValue:t(s).password,"onUpdate:modelValue":r[1]||(r[1]=i=>t(s).password=i),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(u,{class:"mt-2",message:t(s).errors.password},null,8,["message"])]),e("div",q,[a(y,{class:c(["ms-4 w-52 bg-blue-700 flex items-center justify-center",{"opacity-25":t(s).processing}]),disabled:t(s).processing},{default:m(()=>[d(" Log in ")]),_:1},8,["class","disabled"])]),e("div",z,[e("p",null,[d("Don't have an account? "),e("a",{href:o.route("register"),class:"text-blue-600 dark:text-blue-500 dark:hover:text-blue-200 decoration underline hover:text-blue-800"},"Create one!",8,E)])]),e("div",F,[e("p",null,[e("a",{href:o.route("reset"),class:"text-blue-600 decoration underline dark:text-blue-500 dark:hover:text-blue-200 hover:text-blue-800"},"Forgot your password?",8,S)])])],32)],2)]),_:1}))}};export{A as default};
