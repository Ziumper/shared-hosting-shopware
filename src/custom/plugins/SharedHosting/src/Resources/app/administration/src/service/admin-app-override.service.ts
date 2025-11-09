const { Service } = Shopware;

/**
 * It's a custom class for overriding Shopware 6 Admin Panel App features;
 */
export default class AdminAppOverrideService {
    
    /**
    * I could return empty array on Promise resolve whenever the fetching of notifications occurs,
    * but then an error occurs since it's fetched inside timeout again and again.
    * Also I can't really hook into initalization or decorate this service since it's inside Admin App initlization flow.
    * So we could simply allow it to throw errors instead calling api for messages.
    * I override the promise object to return function instead to overcome this problem.
    *
    * It will simply try to make a custom request over and over again.
    * but instead it will simply return then function with then/catch decleration inside.
    * Praise the functional programming!
    */
    static overrideFetchNotifications(): void {
        const notificationsService = Service('notificationsService');
        if (!notificationsService) {
            console.error("No notifications service found");
            return;
        }

        notificationsService.fetchNotifications = function (limit?: number, latestTimestamp?: number | null): any {
          const notifications = [];
          const timestamp = undefined;
          return { 
                then: function (notifications, timestamp) { return { catch: function (error) { return } }},
            };
        };
    }
}
