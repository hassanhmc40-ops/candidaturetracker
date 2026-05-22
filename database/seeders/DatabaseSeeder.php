<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'hassan',
            'email' => 'hassan@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // ──────────────────────────────────────────────
        //  1. Refusée — Google
        // ──────────────────────────────────────────────
        $google = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Google',
            'job_title' => 'Développeur Full Stack',
            'job_url' => 'https://careers.google.com/jobs/123',
            'status' => 'refusee',
            'priority' => 'haute',
            'notes' => "Candidature envoyée via le portail carrières. Retour negatif reçu après trois semaines. Feedback positif sur l'entretien mais le profil n'a pas été retenu.",
            'application_date' => '2026-03-15',
        ]);

        // ──────────────────────────────────────────────
        //  2. Refusée — Capgemini
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Capgemini',
            'job_title' => 'Ingénieur Logiciel',
            'job_url' => 'https://capgemini.jobs/ingenieur-logiciel',
            'status' => 'refusee',
            'priority' => 'moyenne',
            'notes' => "Test technique effectué mais niveau insuffisant en algorithmique et structures de données.",
            'application_date' => '2026-03-28',
        ]);

        // ──────────────────────────────────────────────
        //  3. Entretien planifié — Microsoft
        // ──────────────────────────────────────────────
        $microsoft = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Microsoft',
            'job_title' => 'Développeur Backend C# / .NET',
            'job_url' => 'https://careers.microsoft.com/jobs/dotnet-backend',
            'status' => 'entretien_planifie',
            'priority' => 'haute',
            'notes' => "Premier contact avec le recruteur très encourageant. Entretien technique à préparer : architecture logicielle, design patterns, .NET 8, Azure.",
            'application_date' => '2026-04-28',
        ]);

        Interview::factory()->create([
            'application_id' => $microsoft->id,
            'type' => 'visioconference',
            'scheduled_date' => '2026-05-25',
            'scheduled_time' => '14:00',
            'preparation_notes' => "Préparer les sujets suivants : microservices avec Azure Service Bus, Entity Framework Core, performance et optimisation. Revoir les design patterns (CQRS, Mediator, Repository).",
            'result' => null,
        ]);

        // ──────────────────────────────────────────────
        //  4. En cours — Sopra Steria
        // ──────────────────────────────────────────────
        $sopra = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Sopra Steria',
            'job_title' => 'Consultant Technique Senior',
            'job_url' => null,
            'status' => 'en_cours',
            'priority' => 'moyenne',
            'notes' => "Candidature envoyée suite à une recommandation interne d'un ancien collègue. Échange téléphonique en attente.",
            'application_date' => '2026-05-06',
        ]);

        Interview::factory()->create([
            'application_id' => $sopra->id,
            'type' => 'telephone',
            'scheduled_date' => '2026-05-12',
            'scheduled_time' => '10:30',
            'preparation_notes' => "Préparer un résumé de mon parcours et de mes réalisations clés. Réfléchir à mes motivations pour le conseil et les missions envisagées.",
            'result' => 'en_attente',
        ]);

        // ──────────────────────────────────────────────
        //  5. En attente — Amazon
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Amazon',
            'job_title' => 'Software Development Engineer II',
            'job_url' => 'https://amazon.jobs/sde-2-paris',
            'status' => 'en_attente',
            'priority' => 'basse',
            'notes' => "Poste basé à Paris. Candidature en ligne via le portail Amazon. Les délais de réponse sont généralement longs (3 à 6 semaines).",
            'application_date' => '2026-05-14',
        ]);

        // ──────────────────────────────────────────────
        //  6. Entretien planifié — Ubisoft
        // ──────────────────────────────────────────────
        $ubisoft = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Ubisoft',
            'job_title' => 'Développeur Gameplay (C++)',
            'job_url' => 'https://ubisoft.jobs/gameplay-developer',
            'status' => 'entretien_planifie',
            'priority' => 'urgente',
            'notes' => "Opportunité exceptionnelle dans l'industrie du jeu vidéo. Processus de recrutement en plusieurs étapes sur trois semaines.",
            'application_date' => '2026-05-11',
        ]);

        Interview::factory()->create([
            'application_id' => $ubisoft->id,
            'type' => 'technique',
            'scheduled_date' => '2026-05-27',
            'scheduled_time' => '09:00',
            'preparation_notes' => "Test technique en direct. Réviser : C++ moderne (C++17/20), Unreal Engine 5, algorithmes de rendu, optimisation de performances, mathématiques pour le jeu vidéo.",
            'result' => null,
        ]);

        Interview::factory()->create([
            'application_id' => $ubisoft->id,
            'type' => 'rh',
            'scheduled_date' => '2026-06-02',
            'scheduled_time' => '11:00',
            'preparation_notes' => "Entretien RH (sous réserve de réussite du test technique). Préparer mes prétentions salariales, ma disponibilité et mes questions sur l'équipe et les projets.",
            'result' => null,
        ]);

        // ──────────────────────────────────────────────
        //  7. En cours — BNP Paribas
        // ──────────────────────────────────────────────
        $bnp = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'BNP Paribas',
            'job_title' => 'Architecte Solutions (DSI)',
            'job_url' => 'https://bnpparibas.jobs/architecte-solutions',
            'status' => 'en_cours',
            'priority' => 'haute',
            'notes' => "Poste au sein de la direction des systèmes d'information. Processus géré par un cabinet de recrutement spécialisé.",
            'application_date' => '2026-05-17',
        ]);

        Interview::factory()->create([
            'application_id' => $bnp->id,
            'type' => 'telephone',
            'scheduled_date' => '2026-05-20',
            'scheduled_time' => '15:00',
            'preparation_notes' => "Premier contact avec le responsable recrutement. Présenter mon parcours, mon intérêt pour le secteur bancaire et ma vision de l'architecture logicielle.",
            'result' => 'reussi',
        ]);

        // ──────────────────────────────────────────────
        //  8. En attente — Decathlon
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Decathlon',
            'job_title' => 'Développeur Mobile React Native',
            'job_url' => 'https://decathlon.jobs/react-native-dev',
            'status' => 'en_attente',
            'priority' => 'moyenne',
            'notes' => "Candidature spontanée. L'équipe mobile travaille sur l'application Decathlon pour iOS et Android. Stack technique intéressant et équipe dynamique.",
            'application_date' => '2026-05-19',
        ]);

        // ──────────────────────────────────────────────
        //  9. Offre reçue — Thales
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Thales',
            'job_title' => 'Ingénieur Cybersécurité',
            'job_url' => 'https://thales.jobs/cyber-ingenieur',
            'status' => 'offre_recue',
            'priority' => 'urgente',
            'notes' => "Offre reçue ! Package salarial : 55 000 € brut annuel + intéressement + tickets restaurant. Réponse attendue avant le 30 mai 2026.",
            'application_date' => '2026-05-14',
        ]);

        // ──────────────────────────────────────────────
        // 10. Acceptée — Air France
        // ──────────────────────────────────────────────
        $airfrance = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Air France',
            'job_title' => 'Développeur Web Full Stack',
            'job_url' => 'https://airfrance.jobs/fullstack-dev',
            'status' => 'acceptee',
            'priority' => 'haute',
            'notes' => "Poste accepté ! Prise de fonction prévue le 1er juillet 2026. Stack technique : Laravel, Vue.js, Docker, CI/CD GitLab.",
            'application_date' => '2026-04-20',
        ]);

        Interview::factory()->create([
            'application_id' => $airfrance->id,
            'type' => 'entretien_final',
            'scheduled_date' => '2026-05-05',
            'scheduled_time' => '14:30',
            'preparation_notes' => "Entretien final avec le CTO et le lead tech. Discuter de la vision technique de l'équipe, des projets à venir et de mon rôle.",
            'result' => 'reussi',
        ]);

        // ──────────────────────────────────────────────
        // 11. Refusée — Orange
        // ──────────────────────────────────────────────
        $orange = Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Orange',
            'job_title' => 'DevOps Engineer',
            'job_url' => 'https://orange.jobs/devops-engineer',
            'status' => 'refusee',
            'priority' => 'moyenne',
            'notes' => "Refusé après entretien technique. Manque d'expérience en production Kubernetes et orchestration à grande échelle.",
            'application_date' => '2026-04-29',
        ]);

        Interview::factory()->create([
            'application_id' => $orange->id,
            'type' => 'technique',
            'scheduled_date' => '2026-05-10',
            'scheduled_time' => '11:00',
            'preparation_notes' => "Réviser les concepts CI/CD avancés, Docker multi-stage, Kubernetes (pods, services, ingress), Terraform et Ansible.",
            'result' => 'echoue',
        ]);

        // ──────────────────────────────────────────────
        // 12. En cours — Dassault Systèmes
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Dassault Systèmes',
            'job_title' => 'Développeur Java / JEE',
            'job_url' => 'https://3ds.jobs/java-developer',
            'status' => 'en_cours',
            'priority' => 'moyenne',
            'notes' => "Processus en cours. Test technique à réaliser en ligne sur la plateforme du client. Stack : Java 21, Spring Boot, Kafka, PostgreSQL.",
            'application_date' => '2026-05-18',
        ]);

        // ──────────────────────────────────────────────
        // 13. En attente — SNCF
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'SNCF',
            'job_title' => 'Product Owner Digital',
            'job_url' => null,
            'status' => 'en_attente',
            'priority' => 'basse',
            'notes' => "Reconversion vers le métier de Product Owner. Candidature envoyée via LinkedIn. Le poste est basé à Saint-Denis.",
            'application_date' => '2026-05-21',
        ]);

        // ──────────────────────────────────────────────
        // 14. En attente — DOCTOLIB
        // ──────────────────────────────────────────────
        Application::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Doctolib',
            'job_title' => 'Ingénieur Logiciel Backend',
            'job_url' => 'https://doctolib.jobs/backend-engineer',
            'status' => 'en_attente',
            'priority' => 'haute',
            'notes' => "Start-up en pleine croissance avec une mission qui a du sens. Stack : Ruby on Rails, PostgreSQL, AWS. Processus de recrutement annoncé comme très sélectif.",
            'application_date' => '2026-05-22',
        ]);

        // ──────────────────────────────────────────────
        // Applications archivées (soft-delete)
        // ──────────────────────────────────────────────
        $google->delete();
        $orange->delete();
    }
}
