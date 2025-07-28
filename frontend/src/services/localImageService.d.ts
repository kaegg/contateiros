declare module '@/services/localImageService.js' {
  export const localImageService: {
    addImage(id_local: number, imagemBase64: string): Promise<any>;
    deleteImage(localImagemId: number): Promise<any>;
  };
}
