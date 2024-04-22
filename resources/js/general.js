const randomNumber = (digit) => { 
    return Math.floor(Math.random() * 999 * digit)  
 } ;

 export function randomImages()  {
     return [
         `https://picsum.photos/seed/ecommerce${randomNumber(1)}/600/600`,
         `https://picsum.photos/seed/ecommerce${randomNumber(2)}/600/600`,
         `https://picsum.photos/seed/ecommerce${randomNumber(3)}/600/600`,
         `https://picsum.photos/seed/ecommerce${randomNumber(4)}/600/600`,
     ]
 }
