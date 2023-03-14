import { Router } from '@angular/router';
import { AuthService } from './../../services/auth.service';
import { RankingsService } from './../../services/rankings.service';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-ranking',
  templateUrl: './ranking.component.html',
  styleUrls: ['./ranking.component.css']
})
export class RankingComponent implements OnInit {

  rankings: any;
  nombre: any;
  users: any;
  unirse: boolean = false;
  ver: boolean = false;

  codeForm = new FormGroup({
    code: new FormControl('', [Validators.required]),
  });

  constructor(private rankingsService: RankingsService,
    private authService: AuthService,
    private router: Router) { }

  ngOnInit(): void {
    this.rankingsUsuarios();
  }

  verUnirseRanking() {
    this.unirse = true
  }
  volver() {
    this.ver = false
  }
  rankingsUsuarios() {

    this.rankingsService.rankingsUsuarios(this.authService.user.data[0].id).subscribe({

      next: (value: any) => {
        this.rankings = value.data;
      }
    });
  }

  verRanking(id: number) {

    for (let i = 0; i < this.rankings.length; i++) {
      if (id == this.rankings[i].id) { this.nombre = this.rankings[i].name }

    }

    this.rankingsService.verRankings(id).subscribe({

      next: (value: any) => {
        this.users = value;
        this.ver = true;
      }
    });
  }

  unirseRanking() {

    let code;
    let id;
    code = this.codeForm.controls['code'].value;
    id = this.authService.user.data[0].id;
    this.rankingsService.unirseRankings(code, id).subscribe({

      next: (value: any) => {
        this.users = value;
        this.rankingsUsuarios();
      }
    });
  }

}
