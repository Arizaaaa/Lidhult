import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { RankingsService } from 'src/app/services/rankings.service';

@Component({
  selector: 'app-modificar-ranking',
  templateUrl: './modificar-ranking.component.html',
  styleUrls: ['./modificar-ranking.component.css']
})
export class ModificarRankingComponent implements OnInit {

  users:any;
  id:any;
  ver:boolean = false;
  sumar:boolean = false;
  restar:boolean = false;

  constructor( private rankingsService:RankingsService,
               private authService:AuthService,     
              private router: Router) { }

  ngOnInit(): void {this.verRanking();}
  
  verSumar(id:number){
    this.sumar = true; 
    this.id = id;
    this.restar = false;
  }
  verRestar(id:number){
    this.restar = true;
    this.id = id;
    this.sumar = false;
  }
  volver(){this.router.navigate(['menuProfessor'])}

  verRanking(){
  
    this.rankingsService.verRankings(this.rankingsService.rankigSelected).subscribe({
        
      next: (value: any) => {
        this.users = value;
        this.ver = true;
      }
    });
  }

}
