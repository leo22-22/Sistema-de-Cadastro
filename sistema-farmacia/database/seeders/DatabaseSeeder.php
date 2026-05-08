<?php

namespace Database\Seeders;

use App\Models\Cid10;
use App\Models\Medicamento;
use App\Models\TipoReceita;
use App\Models\TipoRelacaoRemessa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsuarios();
        $this->seedTiposReceita();
        $this->seedTiposRelacaoRemessa();
        $this->seedCid10();
        $this->seedMedicamentos();
    }

    private function seedUsuarios(): void
    {
        User::create([
            'name'     => 'Farmácia Municipal',
            'email'    => 'farmacia@sistema.com',
            'password' => Hash::make('farmacia123'),
            'role'     => 'superadmin',
            'active'   => true,
        ]);

        User::create([
            'name'     => 'Atendente Padrão',
            'email'    => 'atendente@sistema.com',
            'password' => Hash::make('atendente123'),
            'role'     => 'funcionario',
            'active'   => true,
        ]);
    }

    private function seedTiposReceita(): void
    {
        TipoReceita::insert([
            ['nome' => 'Receita Branca Simples',          'cor' => 'secondary', 'requer_retencao' => false, 'descricao' => 'Medicamentos sem controle especial.',                         'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Receita Azul (Psicotrópicos)',     'cor' => 'primary',   'requer_retencao' => true,  'descricao' => 'Psicotrópicos — retenção obrigatória (RDC 344/98).',          'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Receita Amarela (Anabolizantes)',  'cor' => 'warning',   'requer_retencao' => true,  'descricao' => 'Anabolizantes — retenção obrigatória.',                        'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Notificação A (Entorpecentes)',    'cor' => 'danger',    'requer_retencao' => true,  'descricao' => 'Entorpecentes — retenção e notificação obrigatórias.',         'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Receita de Uso Contínuo (RUC)',    'cor' => 'success',   'requer_retencao' => false, 'descricao' => 'Uso contínuo — válida por 6 meses, 3 dispensações.',          'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedTiposRelacaoRemessa(): void
    {
        TipoRelacaoRemessa::insert([
            ['nome' => 'Entrada de Processo',          'descricao' => 'Recebimento e abertura de novo processo de paciente.',             'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Envio para Central',           'descricao' => 'Envio dos processos recebidos para a central estadual.',           'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Devolução de Medicamentos',    'descricao' => 'Devolução de medicamentos não retirados pelo paciente.',           'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Lista — Não Retirou',          'descricao' => 'Relação de pacientes que não retiraram a medicação do mês.',       'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Lista — Retirou (Pedido)',     'descricao' => 'Relação de pacientes que retiraram — base para pedido mensal.',    'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedCid10(): void
    {
        $cids = [
            // Doenças do aparelho circulatório
            ['codigo' => 'I10',   'nome' => 'Hipertensão essencial (primária)',                          'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I11',   'nome' => 'Doença cardíaca hipertensiva',                              'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I20',   'nome' => 'Angina pectoris',                                           'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I21',   'nome' => 'Infarto agudo do miocárdio',                                'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I25',   'nome' => 'Doença isquêmica crônica do coração',                       'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I26',   'nome' => 'Embolia pulmonar',                                          'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I48',   'nome' => 'Fibrilação e flutter atrial',                               'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I50',   'nome' => 'Insuficiência cardíaca',                                    'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I63',   'nome' => 'Infarto cerebral',                                          'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I64',   'nome' => 'Acidente vascular cerebral',                                'categoria' => 'Doenças do aparelho circulatório'],
            ['codigo' => 'I73',   'nome' => 'Outras doenças vasculares periféricas',                     'categoria' => 'Doenças do aparelho circulatório'],

            // Doenças endócrinas, nutricionais e metabólicas
            ['codigo' => 'E10',   'nome' => 'Diabetes mellitus insulino-dependente (Tipo 1)',            'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E11',   'nome' => 'Diabetes mellitus não-insulino-dependente (Tipo 2)',        'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E14',   'nome' => 'Diabetes mellitus não especificado',                        'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E03',   'nome' => 'Outros hipotireoidismos',                                   'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E05',   'nome' => 'Tireotoxicose (hipertireoidismo)',                          'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E06',   'nome' => 'Tireoidite',                                                'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E66',   'nome' => 'Obesidade',                                                 'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E78',   'nome' => 'Distúrbios do metabolismo de lipoproteínas (dislipidemia)', 'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E79',   'nome' => 'Distúrbios do metabolismo de purinas e pirimidinas (gota)', 'categoria' => 'Doenças endócrinas e metabólicas'],
            ['codigo' => 'E80',   'nome' => 'Distúrbios do metabolismo das porfirinas e bilirrubina',    'categoria' => 'Doenças endócrinas e metabólicas'],

            // Transtornos mentais
            ['codigo' => 'F20',   'nome' => 'Esquizofrenia',                                             'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F31',   'nome' => 'Transtorno afetivo bipolar',                                'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F32',   'nome' => 'Episódios depressivos',                                     'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F33',   'nome' => 'Transtorno depressivo recorrente',                          'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F40',   'nome' => 'Transtornos fóbico-ansiosos',                               'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F41',   'nome' => 'Outros transtornos ansiosos',                               'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F84',   'nome' => 'Transtornos globais do desenvolvimento (autismo)',          'categoria' => 'Transtornos mentais e comportamentais'],
            ['codigo' => 'F90',   'nome' => 'Transtornos hipercinéticos (TDAH)',                         'categoria' => 'Transtornos mentais e comportamentais'],

            // Doenças do sistema nervoso
            ['codigo' => 'G20',   'nome' => 'Doença de Parkinson',                                      'categoria' => 'Doenças do sistema nervoso'],
            ['codigo' => 'G35',   'nome' => 'Esclerose múltipla',                                        'categoria' => 'Doenças do sistema nervoso'],
            ['codigo' => 'G40',   'nome' => 'Epilepsia',                                                 'categoria' => 'Doenças do sistema nervoso'],
            ['codigo' => 'G43',   'nome' => 'Enxaqueca (Migrânea)',                                      'categoria' => 'Doenças do sistema nervoso'],
            ['codigo' => 'G45',   'nome' => 'Ataques isquêmicos transitórios cerebrais',                 'categoria' => 'Doenças do sistema nervoso'],
            ['codigo' => 'G71',   'nome' => 'Distrofias musculares primárias',                           'categoria' => 'Doenças do sistema nervoso'],

            // Doenças do aparelho respiratório
            ['codigo' => 'J06',   'nome' => 'Infecções agudas das vias aéreas superiores',              'categoria' => 'Doenças do aparelho respiratório'],
            ['codigo' => 'J18',   'nome' => 'Pneumonia por microorganismo não especificado',             'categoria' => 'Doenças do aparelho respiratório'],
            ['codigo' => 'J45',   'nome' => 'Asma',                                                      'categoria' => 'Doenças do aparelho respiratório'],
            ['codigo' => 'J44',   'nome' => 'Doença pulmonar obstrutiva crônica (DPOC)',                 'categoria' => 'Doenças do aparelho respiratório'],

            // Doenças do aparelho digestivo
            ['codigo' => 'K21',   'nome' => 'Doença de refluxo gastroesofágico (DRGE)',                 'categoria' => 'Doenças do aparelho digestivo'],
            ['codigo' => 'K25',   'nome' => 'Úlcera gástrica',                                          'categoria' => 'Doenças do aparelho digestivo'],
            ['codigo' => 'K50',   'nome' => 'Doença de Crohn',                                           'categoria' => 'Doenças do aparelho digestivo'],
            ['codigo' => 'K51',   'nome' => 'Colite ulcerativa',                                         'categoria' => 'Doenças do aparelho digestivo'],
            ['codigo' => 'K74',   'nome' => 'Fibrose e cirrose hepática',                               'categoria' => 'Doenças do aparelho digestivo'],

            // Doenças do aparelho geniturinário
            ['codigo' => 'N03',   'nome' => 'Síndrome nefrítica crônica',                               'categoria' => 'Doenças do aparelho geniturinário'],
            ['codigo' => 'N04',   'nome' => 'Síndrome nefrótica',                                        'categoria' => 'Doenças do aparelho geniturinário'],
            ['codigo' => 'N18',   'nome' => 'Doença renal crônica',                                      'categoria' => 'Doenças do aparelho geniturinário'],

            // Neoplasias
            ['codigo' => 'C18',   'nome' => 'Neoplasia maligna do cólon',                               'categoria' => 'Neoplasias'],
            ['codigo' => 'C34',   'nome' => 'Neoplasia maligna dos brônquios e pulmão',                 'categoria' => 'Neoplasias'],
            ['codigo' => 'C50',   'nome' => 'Neoplasia maligna da mama',                                 'categoria' => 'Neoplasias'],
            ['codigo' => 'C61',   'nome' => 'Neoplasia maligna da próstata',                             'categoria' => 'Neoplasias'],
            ['codigo' => 'C91',   'nome' => 'Leucemia linfóide',                                         'categoria' => 'Neoplasias'],
            ['codigo' => 'C92',   'nome' => 'Leucemia mielóide',                                         'categoria' => 'Neoplasias'],

            // Doenças osteomusculares
            ['codigo' => 'M05',   'nome' => 'Artrite reumatoide soropositiva',                          'categoria' => 'Doenças osteomusculares'],
            ['codigo' => 'M06',   'nome' => 'Outras artrites reumatoides',                              'categoria' => 'Doenças osteomusculares'],
            ['codigo' => 'M07',   'nome' => 'Artropatias psoriásicas e enteropatias',                   'categoria' => 'Doenças osteomusculares'],
            ['codigo' => 'M08',   'nome' => 'Artrite juvenil',                                           'categoria' => 'Doenças osteomusculares'],
            ['codigo' => 'M45',   'nome' => 'Espondilite anquilosante',                                  'categoria' => 'Doenças osteomusculares'],
            ['codigo' => 'M81',   'nome' => 'Osteoporose sem fratura patológica',                       'categoria' => 'Doenças osteomusculares'],

            // Doenças da pele
            ['codigo' => 'L40',   'nome' => 'Psoríase',                                                  'categoria' => 'Doenças da pele e tecido subcutâneo'],
            ['codigo' => 'L20',   'nome' => 'Dermatite atópica',                                         'categoria' => 'Doenças da pele e tecido subcutâneo'],

            // Doenças infecciosas
            ['codigo' => 'B18',   'nome' => 'Hepatite viral crônica',                                    'categoria' => 'Doenças infecciosas e parasitárias'],
            ['codigo' => 'B20',   'nome' => 'Doença pelo HIV resultando em doenças infecciosas',        'categoria' => 'Doenças infecciosas e parasitárias'],
            ['codigo' => 'B24',   'nome' => 'Doença pelo HIV não especificada (AIDS)',                   'categoria' => 'Doenças infecciosas e parasitárias'],
            ['codigo' => 'A15',   'nome' => 'Tuberculose respiratória',                                  'categoria' => 'Doenças infecciosas e parasitárias'],

            // Doenças do olho
            ['codigo' => 'H26',   'nome' => 'Outras cataratas',                                          'categoria' => 'Doenças do olho e anexos'],
            ['codigo' => 'H40',   'nome' => 'Glaucoma',                                                  'categoria' => 'Doenças do olho e anexos'],

            // Sangue e imunidade
            ['codigo' => 'D50',   'nome' => 'Anemia por deficiência de ferro',                          'categoria' => 'Doenças do sangue e imunidade'],
            ['codigo' => 'D61',   'nome' => 'Outras anemias aplásticas',                                 'categoria' => 'Doenças do sangue e imunidade'],
            ['codigo' => 'D69',   'nome' => 'Púrpura e outras afecções hemorrágicas',                   'categoria' => 'Doenças do sangue e imunidade'],
        ];

        foreach (array_chunk($cids, 20) as $chunk) {
            Cid10::insert(array_map(fn($c) => [...$c, 'ativo' => true], $chunk));
        }
    }

    private function seedMedicamentos(): void
    {
        $medicamentos = [
            // Hipertensão / Cardio
            ['nome' => 'Losartana Potássica',   'principio_ativo' => 'Losartana',       'dosagem' => '50mg',    'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Anti-hipertensivo — bloqueador AT1'],
            ['nome' => 'Enalapril',              'principio_ativo' => 'Enalapril',        'dosagem' => '10mg',    'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 2,    'descricao' => 'Inibidor ECA — anti-hipertensivo'],
            ['nome' => 'Atenolol',               'principio_ativo' => 'Atenolol',         'dosagem' => '25mg',    'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Betabloqueador — anti-hipertensivo'],
            ['nome' => 'Amlodipino',             'principio_ativo' => 'Anlodipino',       'dosagem' => '5mg',     'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Bloqueador de canal de cálcio'],
            ['nome' => 'Furosemida',             'principio_ativo' => 'Furosemida',       'dosagem' => '40mg',    'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Diurético de alça'],

            // Diabetes
            ['nome' => 'Metformina',             'principio_ativo' => 'Metformina',       'dosagem' => '850mg',   'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 2,    'descricao' => 'Antidiabético oral — biguanida'],
            ['nome' => 'Glibenclamida',          'principio_ativo' => 'Glibenclamida',    'dosagem' => '5mg',     'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Sulfonilureia — antidiabético'],
            ['nome' => 'Insulina NPH Humana',    'principio_ativo' => 'Insulina NPH',     'dosagem' => '100 UI/mL','forma_farmaceutica'=> 'injetavel',   'periodicidade' => 'mensal',  'quantidade_diaria' => null, 'descricao' => 'Insulina de ação intermediária'],

            // Tireoide
            ['nome' => 'Levotiroxina Sódica',    'principio_ativo' => 'Levotiroxina',     'dosagem' => '50mcg',   'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Hormônio tireoidiano — hipotireoidismo'],

            // Colesterol
            ['nome' => 'Sinvastatina',           'principio_ativo' => 'Sinvastatina',     'dosagem' => '20mg',    'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Estatina — redução do LDL'],

            // Respiratório
            ['nome' => 'Salbutamol (Aerossol)',  'principio_ativo' => 'Salbutamol',       'dosagem' => '100mcg/dose','forma_farmaceutica'=>'spray',       'periodicidade' => 'mensal',  'quantidade_diaria' => null, 'descricao' => 'Broncodilatador — asma e DPOC'],
            ['nome' => 'Budesonida (Inalação)',  'principio_ativo' => 'Budesonida',       'dosagem' => '200mcg/dose','forma_farmaceutica'=>'spray',       'periodicidade' => 'mensal',  'quantidade_diaria' => null, 'descricao' => 'Corticosteroide inalatório — asma'],

            // Artrite / Reumatologia
            ['nome' => 'Metotrexato',            'principio_ativo' => 'Metotrexato',      'dosagem' => '2,5mg',   'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => null, 'descricao' => 'Imunossupressor — artrite reumatoide'],
            ['nome' => 'Adalimumabe',            'principio_ativo' => 'Adalimumabe',      'dosagem' => '40mg/0,8mL','forma_farmaceutica'=>'injetavel',   'periodicidade' => 'bimestral','quantidade_diaria'=> null,  'descricao' => 'Biológico anti-TNF — artrite reumatoide'],

            // Osteoporose
            ['nome' => 'Alendronato de Sódio',  'principio_ativo' => 'Alendronato',      'dosagem' => '70mg',    'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => null, 'descricao' => 'Bisfosfonato — osteoporose (1x semana)'],

            // Neurologia / Psiquiatria
            ['nome' => 'Carbamazepina',          'principio_ativo' => 'Carbamazepina',    'dosagem' => '200mg',   'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 2,    'descricao' => 'Anticonvulsivante — epilepsia'],
            ['nome' => 'Levodopa + Carbidopa',   'principio_ativo' => 'Levodopa',         'dosagem' => '250/25mg','forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 3,    'descricao' => 'Antiparkinsoniano — Parkinson'],
            ['nome' => 'Clozapina',              'principio_ativo' => 'Clozapina',        'dosagem' => '100mg',   'forma_farmaceutica' => 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Antipsicótico atípico — esquizofrenia'],

            // HIV
            ['nome' => 'Tenofovir + Lamivudina', 'principio_ativo' => 'TDF + 3TC',       'dosagem' => '300/300mg','forma_farmaceutica'=> 'comprimido',  'periodicidade' => 'mensal',  'quantidade_diaria' => 1,    'descricao' => 'Antirretroviral — HIV/AIDS'],
        ];

        foreach ($medicamentos as $m) {
            Medicamento::create([...$m, 'ativo' => true]);
        }
    }
}
