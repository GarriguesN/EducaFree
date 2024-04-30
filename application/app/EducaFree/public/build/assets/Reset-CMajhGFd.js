import{T as u,b as i,q as f,w as m,d as a,u as t,Z as p,e,c as _,t as b,n,h as w,f as g,k as h}from"./app-BCejmdRG.js";import{_ as x,a as y}from"./PrimaryButton-DI8czg0Y.js";import{_ as k,a as v}from"./TextInput-p9P9VEqi.js";import{_ as V}from"./AuthLayout-eiwe6ham.js";import{l as E}from"./logo-BolINHdd.js";import"./ToggleDark-CpMMCBhr.js";const $={class:"border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[26rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white"},B={class:"flex items-center justify-center pt-1 pb-10"},N=["src"],S=e("span",{class:"self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500"},"EducaFree",-1),j=e("div",{class:"pb-5"},[e("p",null," Forgot Your Password? Don't worry, it happens! Just enter your email address below and we'll send you instructions to reset your password. ")],-1),z={class:"flex items-center justify-center mt-10"},T={__name:"Reset",props:{status:String},setup(r){const s=u({email:""}),c=()=>{s.transform(o=>({...o})).post(route("sendEmail"),{onFinish:()=>s.reset("email")})};return(o,l)=>(i(),f(V,{title:"Reset"},{default:m(()=>[a(t(p),{title:"Reset Password"}),e("div",$,[e("div",B,[e("img",{src:t(E),alt:"Logo",class:"h-8 mr-2"},null,8,N),S]),j,r.status?(i(),_("div",{key:0,class:n(["mb-4 font-medium text-sm text-center",{"text-green-600":r.status.type==="Success","text-red-600":r.status.type==="Error"}])},b(r.status.message),3)):w("",!0),e("form",{onSubmit:g(c,["prevent"]),class:"h-full"},[e("div",null,[a(k,{for:"email",value:"Email"}),a(v,{id:"email",modelValue:t(s).email,"onUpdate:modelValue":l[0]||(l[0]=d=>t(s).email=d),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(x,{class:"mt-2",message:t(s).errors.email},null,8,["message"])]),e("div",z,[a(y,{class:n(["ms-4 w-64 bg-blue-700 text-center flex items-center justify-center",{"opacity-25":t(s).processing}]),disabled:t(s).processing},{default:m(()=>[h(" Email password reset link ")]),_:1},8,["class","disabled"])])],32)])]),_:1}))}};export{T as default};
