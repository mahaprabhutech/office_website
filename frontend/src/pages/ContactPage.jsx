import { useState } from "react";
import api from "../services/api";
import PageHero from "../components/PageHero";

const initial = {
  name: "",
  email: "",
  mobile: "",
  company: "",
  service: "",
  budget_range: "",
  message: "",
};

export default function ContactPage() {
  const [form, setForm] = useState(initial);
  const [status, setStatus] = useState("");

  const submit = async (event) => {
    event.preventDefault();
    setStatus("sending");

    try {
      const { data } = await api.post("/contact", form);

      setStatus(data.message || "Your enquiry has been submitted successfully.");
      setForm(initial);
    } catch (error) {
      setStatus(
        error.response?.data?.message ||
          "Unable to submit. Check the backend connection and form fields."
      );
    }
  };

  return (
    <>
      <PageHero
        eyebrow="Contact us"
        title="Tell us what you want to build or improve."
        text="Share your requirement and our team will contact you to understand the next practical step."
      />

      <section className="section">
        <div className="container contact-grid">
          {/* Company contact information */}
          <div className="contact-info">
            <h2>Company Contact</h2>

            <div>
              <span>Email</span>

              <strong>
                <a href="mailto:info@mahaprabhutech.com">
                  info@mahaprabhutech.com
                </a>
              </strong>
            </div>

            <div>
              <span>Phone</span>

              <strong>
                <a href="tel:+917735776060">
                  +91 77357 76060
                </a>
              </strong>
            </div>

            <div>
              <span>Address</span>

              <strong>
                Baulanga, Kujanga Block
                <br />
                Jagatsinghpur District
                <br />
                Odisha, India – 754141
              </strong>
            </div>

            <p>
              For detailed software, website, mobile application or technology
              requirements, submit the enquiry form.
            </p>
          </div>

          {/* Contact form */}
          <form className="form-card" onSubmit={submit}>
            <div className="form-row">
              <label>
                Full name

                <input
                  type="text"
                  required
                  value={form.name}
                  onChange={(event) =>
                    setForm({
                      ...form,
                      name: event.target.value,
                    })
                  }
                />
              </label>

              <label>
                Email

                <input
                  type="email"
                  required
                  value={form.email}
                  onChange={(event) =>
                    setForm({
                      ...form,
                      email: event.target.value,
                    })
                  }
                />
              </label>
            </div>

            <div className="form-row">
              <label>
                Mobile

                <input
                  type="tel"
                  required
                  value={form.mobile}
                  onChange={(event) =>
                    setForm({
                      ...form,
                      mobile: event.target.value,
                    })
                  }
                />
              </label>

              <label>
                Company

                <input
                  type="text"
                  value={form.company}
                  onChange={(event) =>
                    setForm({
                      ...form,
                      company: event.target.value,
                    })
                  }
                />
              </label>
            </div>

            <label>
              Service required

              <select
                value={form.service}
                onChange={(event) =>
                  setForm({
                    ...form,
                    service: event.target.value,
                  })
                }
              >
                <option value="">Select a service</option>
                <option value="Website Development">
                  Website Development
                </option>
                <option value="Mobile Application">
                  Mobile Application
                </option>
                <option value="Custom Software">
                  Custom Software
                </option>
                <option value="Technology Consulting">
                  Technology Consulting
                </option>
              </select>
            </label>

            <label>
              Message

              <textarea
                required
                rows="6"
                value={form.message}
                onChange={(event) =>
                  setForm({
                    ...form,
                    message: event.target.value,
                  })
                }
              />
            </label>

            <button
              type="submit"
              className="button"
              disabled={status === "sending"}
            >
              {status === "sending" ? "Submitting..." : "Send Enquiry"}
            </button>

            {status && status !== "sending" && (
              <p className="form-status">{status}</p>
            )}
          </form>
        </div>
      </section>
    </>
  );
}