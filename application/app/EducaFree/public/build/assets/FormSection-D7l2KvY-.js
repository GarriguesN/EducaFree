import{b as i,c as r,e as t,m as s,P as c,U as m,d as l,w as n,f as p,n as h,h as _}from"./app-BCejmdRG.js";import{_ as u}from"./_plugin-vue_export-helper-DlAUqK2U.js";const x={},k={class:"md:col-span-1 flex justify-between"},g={class:"px-4 sm:px-0"},w={class:"text-lg font-medium text-gray-900 dark:text-white"},b={class:"mt-1 text-sm text-gray-600 dark:text-white"},f={class:"px-4 sm:px-0 dark:text-white"};function $(d,o){return i(),r("div",k,[t("div",g,[t("h3",w,[s(d.$slots,"title")]),t("p",b,[s(d.$slots,"description")])]),t("div",f,[s(d.$slots,"aside")])])}const v=u(x,[["render",$]]),y={class:"md:grid md:grid-cols-3 md:gap-6 dark:bg-zinc-700 dark:text-white"},z={class:"mt-5 md:mt-0 md:col-span-2 dark:bg-zinc-700 dark:text-white"},S={class:"grid grid-cols-6 gap-6 dark:bg-zinc-700 dark:text-white"},B={key:0,class:"dark:bg-zinc-700 dark:border-t dark:border-gray-600 dark:text-white flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"},j={__name:"FormSection",emits:["submitted"],setup(d){const o=c(()=>!!m().actions);return(e,a)=>(i(),r("div",y,[l(v,null,{title:n(()=>[s(e.$slots,"title",{class:"dark:text-white"})]),description:n(()=>[s(e.$slots,"description",{class:"dark:text-white"})]),_:3}),t("div",z,[t("form",{onSubmit:a[0]||(a[0]=p(C=>e.$emit("submitted"),["prevent"]))},[t("div",{class:h(["px-4 py-5 bg-white sm:p-6 shadow dark:bg-zinc-700 dark:text-white",o.value?"sm:rounded-tl-md sm:rounded-tr-md":"sm:rounded-md"])},[t("div",S,[s(e.$slots,"form")])],2),o.value?(i(),r("div",B,[s(e.$slots,"actions")])):_("",!0)],32)])]))}};export{j as _};