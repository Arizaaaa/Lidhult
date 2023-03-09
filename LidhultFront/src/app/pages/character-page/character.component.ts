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

  selected = 'Eze';

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
      if (images[i].level == 1) { this.imgLv1.push(images[i]) }
    }

  }

  cambiarImg(id:number){

    for (let i = 0; i <  this.imgLv1.length; i++) {

      if(id == i){this.faseImagenes[i] = true; this.selected = this.imgLv1[i].name} 
      else { this.faseImagenes[i] = false }
      
    }
  }

}
