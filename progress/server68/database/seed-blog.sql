-- =============================================================================
-- Seed: Articole blog initiale
-- Ruleaza in phpMyAdmin o singura data
-- =============================================================================

-- Categoriile din schema.sql (auto-increment):
-- 1 = Tur Virtual, 2 = Fotografie, 3 = Videografie,
-- 4 = Randare 3D, 5 = Social Media, 6 = Stiri, 7 = Sfaturi
-- Daca ID-urile difera, ajusteaza category_id mai jos.

INSERT INTO `blog_posts` (`slug`, `title`, `excerpt`, `content`, `category_id`, `status`, `author_id`, `published_at`, `created_at`, `updated_at`) VALUES

('5-motive-tur-virtual-3d-imobiliare',
 '5 Motive să alegi un tur virtual 3D ca soluție vizuală în imobiliare',
 'Descoperă de ce tururile virtuale 3D au devenit un instrument esențial pentru agenții imobiliari și dezvoltatori, oferind experiențe imersive clienților.',
 '<p>Tururile virtuale 3D au revoluționat industria imobiliară, oferind o serie de avantaje semnificative:</p>
<h3>1. Experiență imersivă la distanță</h3>
<p>Clienții pot explora proprietățile de oriunde din lume, economisind timp și resurse. Un tur virtual Matterport oferă o experiență aproape identică cu cea fizică.</p>
<h3>2. Vizionări 24/7</h3>
<p>Proprietățile sunt disponibile pentru vizitare virtuală non-stop, eliminând constrângerile de program.</p>
<h3>3. Diferențiere competitivă</h3>
<p>Agențiile care oferă tururi virtuale se disting clar de competiție, atrăgând mai mulți clienți.</p>
<h3>4. Filtrare calificată</h3>
<p>Vizitatorii care vin fizic după un tur virtual sunt deja familiarizați cu proprietatea, crescând rata de conversie.</p>
<h3>5. Conținut reutilizabil</h3>
<p>Turul virtual poate fi integrat pe site-uri, social media și platforme imobiliare, maximizând expunerea.</p>',
 1, 'published', 1, '2025-01-15 10:00:00', '2025-01-15 10:00:00', '2025-01-15 10:00:00'),

('fotografie-imobiliara-6-sfaturi-sedinta-foto',
 'Fotografie imobiliară: 6 sfaturi utile pentru o ședință foto așa cum trebuie',
 'Pregătirea spațiului, iluminarea corectă și unghiurile potrivite fac diferența între o fotografie obișnuită și una care vinde proprietatea rapid.',
 '<p>O ședință foto profesională poate face diferența între o proprietate care se vinde rapid și una care stă luni pe piață.</p>
<h3>1. Pregătirea spațiului</h3>
<p>Curățenia impecabilă și decluttering-ul sunt esențiale. Îndepărtați obiectele personale și dezordinea.</p>
<h3>2. Iluminarea naturală</h3>
<p>Trageți draperiile și lăsați lumina naturală să intre. Programați ședința foto când luminozitatea e optimă.</p>
<h3>3. Unghiuri strategice</h3>
<p>Fotografiați din colțurile camerelor pentru a maximiza percepția spațiului.</p>
<h3>4. Detalii care contează</h3>
<p>Florile proaspete, prosoapele aranjate și lumânările creează o atmosferă primitoare.</p>
<h3>5. Fotografii exterioare</h3>
<p>Nu neglijați exteriorul - fațada, grădina și împrejurimile sunt la fel de importante.</p>
<h3>6. Post-procesare profesională</h3>
<p>Editarea HDR, corectarea culorilor și retușarea fac diferența finală.</p>',
 2, 'published', 1, '2024-12-28 10:00:00', '2024-12-28 10:00:00', '2024-12-28 10:00:00'),

('avantajele-prezentarilor-video-productie',
 'Avantajele prezentărilor video în procesul de producție',
 'Conținutul video de calitate accelerează deciziile de achiziție și oferă transparență în procesele de producție industrială.',
 '<p>Prezentările video au devenit un instrument indispensabil în comunicarea industrială și comercială.</p>
<h3>Transparență și încredere</h3>
<p>Un video bine realizat oferă clienților o privire autentică asupra proceselor de producție, construind încredere în brand.</p>
<h3>Comunicare eficientă</h3>
<p>Un minut de video poate transmite informații echivalente cu mii de cuvinte, făcând mesajul mai accesibil.</p>
<h3>Versatilitate</h3>
<p>Conținutul video poate fi utilizat pe site-ul companiei, social media, prezentări pentru investitori și campanii de marketing.</p>
<h3>ROI măsurabil</h3>
<p>Companiile care investesc în video marketing raportează creșteri semnificative în engagement și conversii.</p>',
 3, 'published', 1, '2024-11-10 10:00:00', '2024-11-10 10:00:00', '2024-11-10 10:00:00'),

('tur-virtual-3d-evenimente-corporate',
 'Cum te ajută un tur virtual 3D în industria evenimentelor corporate',
 'Locațiile pentru evenimente beneficiază enorm de tururi virtuale, permițând organizatorilor să exploreze spațiile de la distanță înainte de a lua o decizie.',
 '<p>Industria evenimentelor corporate a adoptat rapid tururile virtuale 3D ca instrument de prezentare și vânzare.</p>
<h3>Explorare la distanță</h3>
<p>Organizatorii de evenimente pot vizita virtual locații din întreaga țară fără deplasare, economisind timp prețios.</p>
<h3>Planificare precisă</h3>
<p>Cu funcția de măsurători integrate, pot fi planificate aranjamentele, pozițiile scenei și fluxul participanților.</p>
<h3>Prezentare clienților</h3>
<p>Agențiile de evenimente pot trimite link-uri interactive clienților pentru aprobare, eliminând vizitele multiple.</p>
<h3>Marketing și promovare</h3>
<p>Tururile virtuale ale locațiilor de evenimente generează mai mult interes decât fotografiile statice.</p>',
 1, 'published', 1, '2024-10-22 10:00:00', '2024-10-22 10:00:00', '2024-10-22 10:00:00'),

('echipament-matterport-speologie',
 'Utilizarea echipamentului Matterport în speologie',
 'Explorarea și documentarea peșterilor cu tehnologie Matterport deschide noi orizonturi pentru cercetarea științifică și turismul de aventură.',
 '<p>Tehnologia Matterport a deschis noi posibilități în domeniul speologiei, combinând explorarea subterană cu digitalizarea 3D.</p>
<h3>Documentare științifică</h3>
<p>Scanările 3D ale peșterilor oferă cercetătorilor modele digitale precise, utile pentru studii geologice și paleontologice.</p>
<h3>Conservare patrimoniu</h3>
<p>Peșterile cu formațiuni fragile pot fi vizitate virtual, reducând impactul turismului asupra mediului subteran.</p>
<h3>Turism virtual</h3>
<p>Persoanele care nu pot accesa fizic peșterile (din motive de sănătate sau accesibilitate) pot experimenta virtual aceste minuni naturale.</p>
<h3>Provocări tehnice</h3>
<p>Scanarea în medii subterane necesită iluminare suplimentară și echipament rezistent la umiditate.</p>',
 1, 'published', 1, '2024-09-05 10:00:00', '2024-09-05 10:00:00', '2024-09-05 10:00:00'),

('matterport-genesis-generator-ai',
 'Matterport anunță Genesis - Generator AI',
 'Matterport lansează Genesis, un generator AI revoluționar care transformă scanările 3D în modele optimizate automat pentru diverse industrii.',
 '<p>Matterport a anunțat lansarea Genesis, o nouă funcționalitate bazată pe inteligență artificială.</p>
<h3>Ce este Genesis?</h3>
<p>Genesis este un generator AI care procesează automat scanările 3D, optimizându-le pentru diverse utilizări: prezentări imobiliare, planuri de renovare sau documentare industrială.</p>
<h3>Funcționalități cheie</h3>
<p>Generarea automată de planuri de etaj, estimări de suprafață, sugestii de amenajare și integrare cu platforme imobiliare.</p>
<h3>Impact asupra industriei</h3>
<p>Genesis reduce semnificativ timpul de procesare și oferă rezultate consistente, democratizând accesul la modele 3D profesionale.</p>
<h3>Disponibilitate</h3>
<p>Funcționalitatea este disponibilă pentru toți utilizatorii cu abonament Matterport Business și Enterprise.</p>',
 6, 'published', 1, '2024-08-18 10:00:00', '2024-08-18 10:00:00', '2024-08-18 10:00:00'),

('matterport-imobiliare',
 'Cum te ajută Matterport în imobiliare',
 'De la vizionări virtuale la măsurători precise, Matterport oferă agenților imobiliari instrumente puternice pentru a vinde mai rapid și mai eficient.',
 '<p>Matterport a devenit standardul de aur în prezentarea proprietăților imobiliare.</p>
<h3>Tururi virtuale interactive</h3>
<p>Potențialii cumpărători pot explora fiecare cameră în detaliu, navigând liber prin spațiu.</p>
<h3>Planuri de etaj precise</h3>
<p>Funcția Schematic Floor Plans generează automat planuri de etaj cu dimensiuni exacte.</p>
<h3>Fotografii HDR</h3>
<p>Camera Matterport captează simultan modelul 3D și fotografii de înaltă calitate.</p>
<h3>Integrare MLS</h3>
<p>Tururile virtuale se integrează nativ cu cele mai populare platforme imobiliare din România.</p>
<h3>Statistici vizitatori</h3>
<p>Dashboard-ul Matterport oferă date despre vizitatori: timp petrecut, camere vizitate, interes manifestat.</p>',
 1, 'published', 1, '2024-07-02 10:00:00', '2024-07-02 10:00:00', '2024-07-02 10:00:00'),

('conservare-obiective-turistice-matterport',
 'Importanța conservării obiectivelor turistice cu tehnologia Matterport',
 'Digitalizarea monumentelor și a obiectivelor turistice cu Matterport asigură conservarea patrimoniului cultural pentru generațiile viitoare.',
 '<p>Conservarea digitală a patrimoniului cultural a devenit o prioritate globală, iar Matterport oferă instrumentele potrivite.</p>
<h3>Arhivare digitală</h3>
<p>Modelele 3D ale monumentelor servesc drept arhive digitale permanente, capturând starea actuală în detaliu.</p>
<h3>Accesibilitate globală</h3>
<p>Tururile virtuale permit oricui din lume să viziteze monumente istorice, muzee și situri arheologice.</p>
<h3>Instrument educațional</h3>
<p>Școlile și universitățile pot utiliza modelele 3D ca resurse educaționale interactive.</p>
<h3>Planificare restaurare</h3>
<p>Arhitecții și restauratorii pot analiza structurile în detaliu digital înainte de intervențiile fizice.</p>
<h3>Proiecte Scanbox</h3>
<p>Scanbox a realizat digitalizări 3D pentru mai multe obiective turistice din România, contribuind activ la conservarea patrimoniului cultural.</p>',
 1, 'published', 1, '2024-05-15 10:00:00', '2024-05-15 10:00:00', '2024-05-15 10:00:00');
