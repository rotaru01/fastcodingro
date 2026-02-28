<?php
/**
 * Scanbox.ro - Sistem de trimitere email
 *
 * Gestioneaza trimiterea emailurilor folosind functia nativa PHP mail()
 * cu headere corecte pentru format HTML si charset UTF-8.
 * Include template pentru notificari de contact.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Email
{
    /** @var string Adresa expeditorului */
    private string $from;

    /** @var string Numele expeditorului */
    private string $fromName;

    /** @var string Adresa Reply-To */
    private string $replyTo;

    /**
     * Constructor - initializeaza configurarile implicite
     */
    public function __construct()
    {
        $this->from = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'office@scanbox.ro';
        $this->fromName = defined('SITE_NAME') ? SITE_NAME : 'Scanbox.ro';
        $this->replyTo = $this->from;
    }

    /**
     * Trimite un email HTML
     *
     * Configureaza headerele necesare pentru email HTML cu charset UTF-8,
     * MIME, si headere anti-spam. Logheaza erorile de trimitere.
     *
     * @param string $to Adresa destinatarului
     * @param string $subject Subiectul emailului
     * @param string $htmlBody Continutul HTML al emailului
     * @param string|null $replyTo Adresa Reply-To (optional)
     * @return bool True daca emailul a fost trimis cu succes
     */
    public function send(string $to, string $subject, string $htmlBody, ?string $replyTo = null): bool
    {
        /** Validam adresa destinatarului */
        if (!Security::validateEmail($to)) {
            error_log(sprintf(
                '[%s] Adresa de email invalida: %s',
                date('Y-m-d H:i:s'),
                $to
            ));
            return false;
        }

        /** Construim headerele emailului */
        $boundary = md5((string) time());

        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'Content-Transfer-Encoding: 8bit';
        $headers[] = sprintf('From: %s <%s>', $this->encodeHeader($this->fromName), $this->from);
        $headers[] = sprintf('Reply-To: %s', $replyTo ?? $this->replyTo);
        $headers[] = sprintf('X-Mailer: %s/PHP-%s', $this->fromName, phpversion());
        $headers[] = 'X-Priority: 3';
        $headers[] = sprintf('Message-ID: <%s@%s>', $boundary, parse_url(SITE_URL, PHP_URL_HOST) ?? 'scanbox.ro');

        /** Encodam subiectul pentru caractere romanesti */
        $encodedSubject = $this->encodeHeader($subject);

        /** Invelim continutul HTML in template-ul de baza */
        $fullHtml = $this->wrapInTemplate($htmlBody, $subject);

        /** Trimitem emailul */
        $sent = @mail($to, $encodedSubject, $fullHtml, implode("\r\n", $headers));

        if (!$sent) {
            error_log(sprintf(
                '[%s] Eroare trimitere email catre: %s, subiect: %s',
                date('Y-m-d H:i:s'),
                $to,
                $subject
            ));
        }

        return $sent;
    }

    /**
     * Trimite notificarea de mesaj nou de contact
     *
     * Formateaza datele contactului intr-un email HTML frumos
     * si il trimite la adresa administratorului.
     *
     * @param array $contactData Datele contactului (name, email, phone, service_interest, message)
     * @return bool True daca emailul a fost trimis cu succes
     */
    public function sendContactNotification(array $contactData): bool
    {
        $name = Security::escapeOutput($contactData['name'] ?? '');
        $email = Security::escapeOutput($contactData['email'] ?? '');
        $phone = Security::escapeOutput($contactData['phone'] ?? 'Nespecificat');
        $service = Security::escapeOutput($contactData['service_interest'] ?? 'Nespecificat');
        $message = nl2br(Security::escapeOutput($contactData['message'] ?? ''));
        $date = date('d.m.Y H:i');

        $htmlBody = <<<HTML
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h2 style="color: #1a1a2e; margin-top: 0; border-bottom: 2px solid #e94560; padding-bottom: 10px;">
                Mesaj nou de contact
            </h2>
            <p style="color: #666; font-size: 14px;">
                Primit pe {$date}
            </p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 12px 15px; background-color: #f1f3f5; font-weight: bold; width: 150px; border-bottom: 1px solid #dee2e6;">
                    Nume
                </td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6;">
                    {$name}
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 15px; background-color: #f1f3f5; font-weight: bold; border-bottom: 1px solid #dee2e6;">
                    Email
                </td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6;">
                    <a href="mailto:{$email}" style="color: #e94560;">{$email}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 15px; background-color: #f1f3f5; font-weight: bold; border-bottom: 1px solid #dee2e6;">
                    Telefon
                </td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6;">
                    {$phone}
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 15px; background-color: #f1f3f5; font-weight: bold; border-bottom: 1px solid #dee2e6;">
                    Serviciu dorit
                </td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6;">
                    {$service}
                </td>
            </tr>
        </table>

        <div style="background-color: #fff; padding: 20px; border-left: 4px solid #e94560; margin-bottom: 20px;">
            <h3 style="color: #1a1a2e; margin-top: 0;">Mesaj:</h3>
            <p style="color: #333; line-height: 1.6; white-space: pre-wrap;">
                {$message}
            </p>
        </div>

        <div style="text-align: center; padding: 15px; background-color: #1a1a2e; border-radius: 8px;">
            <a href="mailto:{$email}" style="display: inline-block; padding: 10px 30px; background-color: #e94560; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Raspunde la {$name}
            </a>
        </div>
        HTML;

        $subject = sprintf('[%s] Mesaj nou de la %s', SITE_NAME, $name);

        return $this->send(ADMIN_EMAIL, $subject, $htmlBody, $email);
    }

    /**
     * Trimite confirmare catre persoana care a completat formularul de contact
     *
     * @param string $toEmail Adresa email a persoanei
     * @param string $toName Numele persoanei
     * @return bool True daca emailul a fost trimis
     */
    public function sendContactConfirmation(string $toEmail, string $toName): bool
    {
        $name = Security::escapeOutput($toName);
        $siteUrl = SITE_URL;

        $htmlBody = <<<HTML
        <div style="text-align: center; padding: 30px 20px; background-color: #1a1a2e; border-radius: 8px; margin-bottom: 20px;">
            <h2 style="color: #ffffff; margin: 0;">Multumim pentru mesaj!</h2>
        </div>

        <div style="padding: 20px;">
            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                Draga {$name},
            </p>
            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                Mesajul tau a fost primit cu succes. Echipa noastra il va analiza si te va contacta
                in cel mai scurt timp posibil, de obicei in termen de 24 de ore.
            </p>
            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                Intre timp, te invitam sa explorezi portofoliul nostru de lucrari pe
                <a href="{$siteUrl}/portofoliu" style="color: #e94560; font-weight: bold;">pagina noastra de portofoliu</a>.
            </p>
            <p style="color: #333; font-size: 16px; line-height: 1.6;">
                Cu respect,<br>
                <strong>Echipa Scanbox</strong>
            </p>
        </div>
        HTML;

        return $this->send($toEmail, 'Multumim pentru mesajul tau - ' . SITE_NAME, $htmlBody);
    }

    /**
     * Inveleste continutul HTML in template-ul de baza al emailului
     *
     * @param string $body Continutul HTML
     * @param string $title Titlul emailului
     * @return string Emailul HTML complet
     */
    private function wrapInTemplate(string $body, string $title): string
    {
        $siteUrl = SITE_URL;
        $siteName = Security::escapeOutput(SITE_NAME);
        $year = date('Y');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="ro">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$title}</title>
        </head>
        <body style="margin: 0; padding: 0; background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5;">
                <tr>
                    <td align="center" style="padding: 20px 10px;">
                        <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <!-- Header -->
                            <tr>
                                <td style="padding: 20px; text-align: center; background-color: #1a1a2e;">
                                    <a href="{$siteUrl}" style="color: #ffffff; text-decoration: none; font-size: 24px; font-weight: bold;">
                                        {$siteName}
                                    </a>
                                </td>
                            </tr>
                            <!-- Continut -->
                            <tr>
                                <td style="padding: 30px 25px;">
                                    {$body}
                                </td>
                            </tr>
                            <!-- Footer -->
                            <tr>
                                <td style="padding: 20px; text-align: center; background-color: #f8f9fa; border-top: 1px solid #dee2e6;">
                                    <p style="margin: 0; font-size: 12px; color: #999;">
                                        &copy; {$year} {$siteName}. Toate drepturile rezervate.
                                    </p>
                                    <p style="margin: 5px 0 0; font-size: 12px; color: #999;">
                                        <a href="{$siteUrl}" style="color: #e94560; text-decoration: none;">{$siteUrl}</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }

    /**
     * Encodeaza un header pentru suportul caracterelor UTF-8
     *
     * Foloseste codificarea RFC 2047 (=?UTF-8?B?...?=) pentru
     * a permite caractere romanesti in subiect si nume.
     *
     * @param string $text Textul de encodat
     * @return string Textul encodat pentru headere email
     */
    private function encodeHeader(string $text): string
    {
        if (mb_check_encoding($text, 'ASCII')) {
            return $text;
        }

        return '=?UTF-8?B?' . base64_encode($text) . '?=';
    }

    /**
     * Seteaza adresa expeditorului
     *
     * @param string $email Adresa email
     * @param string $name Numele expeditorului
     * @return self
     */
    public function setFrom(string $email, string $name = ''): self
    {
        $this->from = $email;
        if (!empty($name)) {
            $this->fromName = $name;
        }
        return $this;
    }

    /**
     * Seteaza adresa Reply-To
     *
     * @param string $email Adresa Reply-To
     * @return self
     */
    public function setReplyTo(string $email): self
    {
        $this->replyTo = $email;
        return $this;
    }
}
