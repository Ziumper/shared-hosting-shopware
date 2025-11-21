const{Service:t}=Shopware;class e{static overrideFetchNotifications(){const i=t("notificationsService");if(!i){console.error("No notifications service found");return}i.fetchNotifications=function(n,r){return{then:function(c,s){return{catch:function(a){}}}}}}}e.overrideFetchNotifications();
//# sourceMappingURL=shared-hosting-BUD6rxZa.js.map
