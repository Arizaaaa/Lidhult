import { AuthService } from './../../services/auth.service';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { RankingsService } from 'src/app/services/rankings.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-menu-professor',
  templateUrl: './menu-professor.component.html',
  styleUrls: ['./menu-professor.component.css']
})
export class MenuProfessorComponent implements OnInit {

  rankings:any;

  constructor( public rankingsService:RankingsService,
               private authService:AuthService,
               private route:Router) { }

  ngOnInit(): void {
    this.rankingsUsuarios();
  }
  modificarRanking(){
    this.route.navigate(['modificarRanking'])
  }
  volver(){
    this.rankingsService.ver = false
  }

  ranking(id:number){ this.rankingsService.ver = true; this.rankingsService.rankigSelected = id;}

  rankingsUsuarios(){
    
    this.rankingsService.rankingsProfesor(this.authService.user.data[0].id).subscribe({
        
      next: (value: any) => {
        this.rankings = value.data;
      }
    });
  }

}
