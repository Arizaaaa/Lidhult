import { CharacterService } from './../../services/character.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-character',
  templateUrl: './character.component.html',
  styleUrls: ['./character.component.css']
})
export class CharacterComponent implements OnInit {

  constructor(private characterService:CharacterService) { }

  images:any = [];
  imgLv1:any = [];
  imgLv2:any = [];
  imgLv3:any = [];
  imgLv4:any = [];
  imgLv5:any = [];

  ngOnInit(): void {
    this.recogerImg();
  }
  img0 = true;
  img1 = false;
  img2 = false;
  img3 = false;
  img4 = false;
  img5 = false;
  faseImagenes: boolean[] = [this.img0 ,this.img1, this.img2, this.img3, this.img4, this.img5]

  recogerImg(){

    this.characterService.imagenes().subscribe({ 
      next: (value: any) => {        
        this.images = value.data;
        this.ordenarImg(this.images);
      }
    });
  }

  ordenarImg(images:any){

    for (let i = 0; i < images.length; i++) {

      if (images[i].level == 1) { this.imgLv1.push(images[i].link) }
      else if (images[i].level == 2){ this.imgLv2.push(images[i]) }
      else if (images[i].level == 3){ this.imgLv3.push(images[i]) }
      else if (images[i].level == 4){ this.imgLv4.push(images[i]) }
      else if (images[i].level == 5){ this.imgLv5.push(images[i]) }
    }
   
  }

  cambiarImg(id:number){

  }

}
