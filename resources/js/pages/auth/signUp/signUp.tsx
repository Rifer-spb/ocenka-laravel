import AppLayout from "@/layouts/app-layout";
import styles from "./signUp.module.css";

export default function SignUp() {
    return (
        <>
            <AppLayout>
                <div className={styles.singUp}>
                    <h1>Регистрация</h1>
                    <form>
                        <div className="form-group">
                            <label>Ваш e-mail</label>
                            <input type="text" className="form-control"/>
                            <p className="error"></p>
                        </div>
                        <div className="form-group">
                            <label>Придумайте пароль</label>
                            <input type="password" className="form-control" v-model="fields.password.value"/>
                            <p className="error"></p>
                        </div>
                        <div className="form-group">
                            <div>
                                <input type="radio" value="phys"/>
                                <a href="#">
                                    Регистрация нового физического лица (сотрудника)
                                </a>
                            </div>
                            <div>
                                <input type="radio" value="legal"/>
                                <a href="#">
                                    Регистрация нового юридического лица
                                </a>
                                <p className="error"></p>
                            </div>
                        </div>
                        <div className="form-group">
                            <button className="btn btn-success" type="submit">Зарегистрироваться</button>
                        </div>
                    </form>
                </div>
            </AppLayout>
        </>
    );
}
