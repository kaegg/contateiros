declare module '@/services/api.js' {
  export const localService: {
    getAll(): Promise<any>;
    getById(id: any): Promise<any>;
    create(localData: any): Promise<any>;
    update(id: any, localData: any): Promise<any>;
    delete(id: any): Promise<any>;
    getImages(localId: any): Promise<any>;
    getActivities(localId: any): Promise<any>;
    getFacilities(localId: any): Promise<any>;
    getRatings(localId: any): Promise<any>;
  };
  
  export const ratingService: {
    create(ratingData: any): Promise<any>;
    update(id: any, ratingData: any): Promise<any>;
    delete(id: any): Promise<any>;
  };
  
  export const imageService: {
    upload(imageData: any): Promise<any>;
    delete(id: any): Promise<any>;
  };
  
  export const activityService: {
    getAll(): Promise<any>;
  };
  
  export const facilityService: {
    getAll(): Promise<any>;
  };
}
